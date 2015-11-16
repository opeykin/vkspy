package org.vkspy

public class VkAccessor {
    object Data {
        val httpClient = HttpClientWrapper()
        val apiUrl = "https://api.vk.com/method/"
    }

    fun checkOnline(ids: List<String>): String {
        if (ids.size > 1000)
            throw Exception("too match ids. 1000 is limit")

        var url = createOnlineRequestUrl(ids.joinToString(","))
        return Data.httpClient.executeGet(url)
    }

    private fun createOnlineRequestUrl(id: String): String {
        return "${Data.apiUrl}users.get?uids=$id&fields=online"
    }
}