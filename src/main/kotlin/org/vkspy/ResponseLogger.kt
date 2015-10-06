package org.vkspy

class ResponseLogger {
    fun log(response: OnlineResponse): Unit {
        response.response.forEach { println(it) }
    }
}