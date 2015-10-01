package org.vkspy

public class StatusLogger {
    public fun log(statuses: List<OnlineStatus>) {
        statuses.forEach { println(it) }
    }
}