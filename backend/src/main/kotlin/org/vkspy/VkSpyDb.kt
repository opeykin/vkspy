package org.vkspy

import java.sql.DriverManager

public class VkSpyDb {
    private object Const {
        val url = "jdbc:postgresql://localhost:5432/alex"
        val username = "vkspy_stat_collector"
        val password = "password"
    }

    //TODO: we do not close connection for now...
    val connection = DriverManager.getConnection(Const.url, Const.username, Const.password)

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
        } catch (ex: Exception) {
            connection.close()
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