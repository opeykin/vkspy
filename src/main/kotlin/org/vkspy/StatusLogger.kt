package org.vkspy

public class StatusLogger {
    public fun log(response: OnlineResponse) {
        response.response.forEach { println(it) }
    }
}