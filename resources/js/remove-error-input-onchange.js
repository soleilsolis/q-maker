$(':input').on('change',function(){
	$(this).parent().removeClass('error');
});