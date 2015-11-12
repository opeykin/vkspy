package org.vkspy

import java.sql.DriverManager

public class DBWriter {
    private object Const {
        val url = "jdbc:postgresql://localhost:5432/alex"
        val username = "vkspy_stat_collector"
        val password = "password"
    }

    //TODO: we do not close connection for now...
    val connection = DriverManager.getConnection(Const.url, Const.username, Const.password)

    public fun write(response: OnlineResponse) {
        try {
            response.response.forEach { write(it) }
        } catch (ex: Exception) {
            connection.close()
        }
    }

    private fun write(status: OnlineStatus) {
        val statement = connection.createStatement()
        var sql = createInsertRequest(status)
        statement.executeUpdate(sql)
        statement.close()
    }

    private fun createInsertRequest(s: OnlineStatus): String {
        return "INSERT INTO stats (uid, online, mobile, app, time) values (" +
                "${s.uid}, ${s.online.toBoolean()}, ${s.online_mobile.toBoolean()}, ${s.online_app}, now());"
    }
}