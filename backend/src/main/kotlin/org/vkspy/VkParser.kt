package org.vkspy

import com.fasterxml.jackson.module.kotlin.jacksonObjectMapper
import com.fasterxml.jackson.module.kotlin.readValue

public class VkParser {
    public fun parseOnline(json: String): Collection<ResponseEntry> {
        val mapper = jacksonObjectMapper()
        val response = mapper.readValue<ResponseEntry>(json)
        return response.response;
    }
}