package org.vkspy

import org.vkspy.util.toBoolean
import java.sql.Connection
import java.sql.DriverManager

public class VkSpyDb(val connection: Connection) {
    fun getUserIds(): Collection<Int> {
        val statement = connection.createStatement();
        val result = statement.executeQuery("SELECT uid FROM users")

        val list = arrayListOf<Int>()

        while (result.next()) {
            list.add(result.getInt("uid"));
        }

        return list;
    }

    public fun writeStatuses(statuses: Collection<OnlineStatus>) {
        try {
            statuses.filter { it.online != 0 }.forEach { writeStatus(it) }
        } catch(e: Exception) {
            connection.close()
            throw e
        }
    }

    private fun writeStatus(status: OnlineStatus) {
        val statement = connection.createStatement()
        var sql = createInsertRequest(status)
        statement.executeUpdate(sql)
        statement.close()
    }

    private fun createInsertRequest(s: OnlineStatus): String {
        return "INSERT INTO stats (uid, mobile, app, time) values (" +
                "${s.uid}, ${s.online_mobile.toBoolean()}, ${s.online_app}, now());"
    }
}

fun newVkSpyDb(url: String, userName: String, password: String): VkSpyDb {
    val connection = DriverManager.getConnection(url, userName, password)
    return VkSpyDb(connection)
}