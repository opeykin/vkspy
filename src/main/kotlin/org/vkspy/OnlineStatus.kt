package org.vkspy

import java.time.LocalDateTime

data class OnlineStatus(var dateTimeUTC: LocalDateTime, val id: Int, val online: Int, val mobile: Int)