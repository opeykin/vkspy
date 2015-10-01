package org.vkspy

import com.google.gson.JsonElement
import com.google.gson.JsonParser
import java.time.LocalDateTime
import java.time.ZoneId

public class VkParser {
    public fun parseOnline(response: String): List<OnlineResponse> {
        val obj = JsonParser().parse(response).asJsonObject
        val array = obj.get("response").asJsonArray
        return array.map { parseSingleOnline(it) }
    }

    fun parseSingleOnline(elem: JsonElement): OnlineResponse {
        val jsonObject = elem.asJsonObject
        val id = jsonObject.get("uid").asInt
        val online = jsonObject.get("online").asInt
        val mobile = jsonObject.get("online_mobile")?.asInt ?: 0
        val dateTimeUTC = LocalDateTime.now(ZoneId.of("UTC"))
        return OnlineResponse(dateTimeUTC, id, online, mobile)
    }
}