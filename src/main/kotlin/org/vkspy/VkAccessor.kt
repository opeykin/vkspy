package org.vkspy

public class VkAccessor {
    object Data {
        val httpClient = HttpClientWrapper()
        val parser = VkParser()
        val apiUrl = "https://api.vk.com/method/"
    }

    fun checkOnline(ids: List<String>): List<OnlineResponse> {
        if (ids.size() > 1000)
            throw Exception("too match ids. 1000 is limit")

        var url = createOnlineRequestUrl(ids.join(","))
        val response = Data.httpClient.executeGet(url)
        return Data.parser.parseOnline(response)
    }

    private fun createOnlineRequestUrl(id: String): String {
        return "${Data.apiUrl}users.get?uids=$id&fields=online"
    }
}