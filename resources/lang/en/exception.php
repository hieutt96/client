<?php

return 
	
	[
		\App\Exceptions\AppException::ERR_NONE => 'Thành công',
		\App\Exceptions\AppException::ERR_ACCOUNT_NOT_FOUND => 'Không tìm thấy tài khoản',
		\App\Exceptions\AppException::ERR_SYSTEM => 'Lỗi hệ thống',
		\App\Exceptions\AppException::USER_NOT_EXISTS => 'Không tìm thấy người dùng có email trên',
		\App\Exceptions\AppException::ACCOUNT_NOT_ACTIVE => 'Sai thông tin đăng nhập hoặc tài khoản chưa được Active !',
		\App\Exceptions\AppException::ERR_ENOUGH_BALANCE => 'Số tiền vượt quá hạn số dư',
		\App\Exceptions\AppException::ERR_PHONE_INVAILD => 'Số điện thoại không hợp lệ',
		\App\Exceptions\AppException::ERR_CONNECT_REDIS => 'Lỗi kết nối đến Redis Server',
		\App\Exceptions\AppException::ERR_NOT_SUPPORT => 'Phương thức hiện tại chưa hỗ trợ',
		\App\Exceptions\AppException::ERR_ORDER_NOT_FOUND => 'Không tìm thấy mã đơn hàng',
		\App\Exceptions\AppException::ERR_CHECKSUM_NOT_FOUND => 'Không tìm thấy mã checksum',
		\App\Exceptions\AppException::ERR_CHECKSUM_INVALID => 'Mã checksum không trùng nhau',
	];
