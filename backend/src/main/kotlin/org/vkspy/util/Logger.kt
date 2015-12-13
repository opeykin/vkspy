package org.vkspy.util

import org.slf4j.Logger
import org.slf4j.LoggerFactory

object Logger {
    val logger = LoggerFactory.getLogger("main");

    fun get(): Logger {
        return logger;
    }

    fun logException(e: Exception, msg: String = ""): Unit {
        logger.error(msg, e)
    }
}
