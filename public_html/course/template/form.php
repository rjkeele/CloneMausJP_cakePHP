<form method="post" action="<!--FORM_URL-->">
	<fieldset>
	<label for="firstname">お名前（姓名）</label>
	<input type="text" id="firstname" name="firstname" value=""> <input type="text" id="lastname" name="lastname" value="">
	<label for="email">メールアドレス</label>
	<input type="text" id="email" name="email" value="">
<!--FORM_ORDER_NO-->
	<label for="order_no">注文No</label>
	<input type="text" id="order_no" name="order_no" value="">
<!--END_FORM_ORDER_NO-->
	<label></label>
	<input name="status" type="hidden" value="LOGIN" />
	<input type="submit" id="login" name="login" value=" 登 録 "  class="btn btn-primary">
	</fieldset>
</form>
