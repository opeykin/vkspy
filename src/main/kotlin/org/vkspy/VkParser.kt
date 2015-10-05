package org.vkspy

import com.fasterxml.jackson.module.kotlin.jacksonObjectMapper
import com.fasterxml.jackson.module.kotlin.readValue
import java.time.LocalDateTime
import java.time.ZoneId

public class VkParser {
    public fun parseOnline(json: String): OnlineResponse {
        val mapper = jacksonObjectMapper()
        val response = mapper.readValue<OnlineResponse>(json)
        response.dateTimeUTC = LocalDateTime.now(ZoneId.of("UTC"))
        return response
    }
}