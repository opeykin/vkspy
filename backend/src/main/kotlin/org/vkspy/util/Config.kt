package org.vkspy.util

import java.io.FileInputStream
import java.util.*

public object Config {
    private val prop: Properties = readProperties("config.cfg")

    public val TimerSpan: Long = readLong("TimerSpan")
    public val DbUrl: String = readString("DbUrl")
    public val DbUserName: String = readString("DbUserName")
    public val DbPassword: String = readString("DbPassword")


    private fun readProperties(path: String): Properties {
        val config = Properties()
        val stream = FileInputStream(path)

        config.load(stream)
        stream.close()

        return config
    }

    private fun readString(key: String): String {
        return prop.getProperty(key)
    }

    private fun readInt(key: String): Int {
        val value = prop.getProperty(key)
        return value.toInt()
    }

    private fun readLong(key: String): Long {
        val value = prop.getProperty(key)
        return value.toLong()
    }

    private fun readDouble(key: String): Double {
        val value = prop.getProperty(key)
        return value.toDouble()
    }

    private fun readBoolean(key: String): Boolean {
        val value = prop.getProperty(key)
        return value.toBoolean()
    }
}



