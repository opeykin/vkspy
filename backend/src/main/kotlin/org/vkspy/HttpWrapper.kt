package org.vkspy

import org.apache.commons.io.IOUtils
import org.apache.http.client.HttpClient
import org.apache.http.client.methods.HttpGet
import org.apache.http.client.methods.HttpUriRequest
import org.apache.http.conn.scheme.Scheme
import org.apache.http.conn.ssl.SSLSocketFactory
import org.apache.http.impl.client.DefaultHttpClient
import org.apache.http.impl.conn.tsccm.ThreadSafeClientConnManager
import java.io.IOException
import java.security.cert.CertificateException
import java.security.cert.X509Certificate
import javax.net.ssl.SSLContext
import javax.net.ssl.TrustManager
import javax.net.ssl.X509TrustManager

/**
 * Eases using [HttpClient] for performing requests to vk.com

 * @author Alexey Grigorev
 */
class HttpClientWrapper(private val httpClient: HttpClient) {

    public constructor() : this(wrapClient(DefaultHttpClient())) {
    }

    /**
     * Executes GET request and returns response in string

     * @param uri for the request
     * *
     * @return string response
     * *
     */
    public fun executeGet(uri: String): String {
        return executeRequest(HttpGet(uri))
    }

    private fun executeRequest(request: HttpUriRequest): String {
        try {
            val response = httpClient.execute(request)
            val entity = response.entity
            return IOUtils.toString(entity.content, "UTF-8")
        } catch (e: IOException) {
            throw RuntimeException(e)
        }

    }

    companion object {

        /**
         * Wraps [HttpClient] so it can be used for https requests without
         * special certificates and it can work in concurrent environment

         * @param base object to be wrapped
         * *
         * @return wrapped [HttpClient]
         */
        private fun wrapClient(base: HttpClient): HttpClient {
            // http://javaskeleton.blogspot.com/2010/07/avoiding-peer-not-authenticated-with.html
            // wrapping the client to successfully perform https queries without any
            // certificates

            try {
                val ctx = SSLContext.getInstance("TLS")
                ctx.init(null, arrayOf<TrustManager>(dontCareTrustManager), null)
                val ssf = SSLSocketFactory(ctx)

                val baseCcm = base.connectionManager
                val sr = baseCcm.schemeRegistry
                sr.register(Scheme("https", 443, ssf))

                // http://stackoverflow.com/questions/4612573/exception-using-httprequest-execute-invalid-use-of-singleclientconnmanager-c
                // http://foo.jasonhudgins.com/2010/03/http-connections-revisited.html
                // avoiding
                // "invalid use of SingleClientConnManager: connection still allocated."
                // exception

                val safeCcm = ThreadSafeClientConnManager(sr)
                return DefaultHttpClient(safeCcm, base.params)
            } catch (ex: Exception) {
                throw RuntimeException(ex)
            }

        }

        /**
         * Accepts all given certificates
         */
        private val dontCareTrustManager = object : X509TrustManager {
            private var empty = emptyArray<X509Certificate>()

            override fun getAcceptedIssuers(): Array<X509Certificate> {
                return empty
            }

            @Throws(CertificateException::class)
            override fun checkServerTrusted(ar: Array<X509Certificate>, st: String) {
            }

            @Throws(CertificateException::class)
            override fun checkClientTrusted(ar: Array<X509Certificate>, st: String) {
            }
        }
    }

}
