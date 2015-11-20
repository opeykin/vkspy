package org.vkspy

import com.fasterxml.jackson.module.kotlin.jacksonObjectMapper
import com.fasterxml.jackson.module.kotlin.readValue

public class VkParser {
    public fun parseOnline(json: String): Collection<OnlineStatus> {
        val mapper = jacksonObjectMapper()
        val response = mapper.readValue<OnlineResponse>(json)
        return response.response;
    }
}