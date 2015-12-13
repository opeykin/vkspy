package org.vkspy

import org.vkspy.util.Config
import org.vkspy.util.Logger

fun main(args: Array<String>) {
    try {
        val accessor = VkAccessor()
        val parser = VkParser()
        val db = newVkSpyDb(Config.DbUrl, Config.DbUserName, Config.DbPassword)

        kotlin.concurrent.timer("MyTimer", false, 0, Config.TimerSpan, {
            while (true) {
                try {
                    val ids = db.getUserIds()
                    val json = accessor.checkOnline(ids)
                    val statuses = parser.parseOnline(json)
                    db.writeStatuses(statuses)
                    Logger.get().trace("Got ${statuses.size} statuses")
                } catch (e: Exception) {
                    Logger.logException(e)
                }
            }
        });


    } catch (e: Exception) {
        Logger.logException(e, "Initialization")
        throw e
    }
}
