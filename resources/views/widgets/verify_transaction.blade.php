<link rel="stylesheet" type="text/css" href="{{asset('/css/main.css')}}">
@switch($verifyBy)
    @case('g')
	    <input id="verification_code" class="select-g2fa" name="verification_code" type="text" required value="" />
		<label for="verification_code" alt="Mã xác thực Google Authenticator" placeholder="Mã xác thực Google Authenticator"></label>
    @break
    @default
    	<input id="verification_code" name="verification_code" type="password" class="select-pass" required value="" />
		<label for="verification_code" alt="Mật khẩu giao dịch" placeholder="Mật khẩu giao dịch"></label>
@endswitch
