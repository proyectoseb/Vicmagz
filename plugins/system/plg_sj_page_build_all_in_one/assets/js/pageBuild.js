	
	/*-----------------------------------js add layout column-----------------------------------------*/
	var check_wrap_sj_add_row = 0;
	$('body').on('mouseover','.wrap_sj_add_row',function(){
		if(!$(this).hasClass('sj_open')){
			if($('.sj_open').length > 0){
			check_wrap_sj_add_row = 0;
			$('.sj_open').find('.sj_select_label_row').animate({height: "0px"},300);
			$('.wrap_sj_add_row').removeClass('sj_open');
		}
		}
			if(check_wrap_sj_add_row == 0){
				$(this).find('.sj_select_label_row').animate({height: "64px"},300);
				$('.wrap_sj_add_row').removeClass('sj_open');
				$(this).addClass('sj_open');
				check_wrap_sj_add_row = 1;
			}
	})
	
	$('body').click(function(){
		if($('.sj_open').length > 0){
			check_wrap_sj_add_row = 0;
			$('.sj_open').find('.sj_select_label_row').animate({height: "0px"},300);
			$('.wrap_sj_add_row').removeClass('sj_open');
		}
	})
	/*----------------------------------------------------------------------------*/
		
	/*---------------------------------js sj_column_active-------------------------------------------*/
	$('body').on('click','.sj_wrap_add_row .sj_column',function(){
		var parent = $(this).parent();
		var index = $(this).index();
		var data_layout = $(this).attr('data-layout');
		add_row_fuild($('.wrap_sj_content'),index,data_layout,action_row);
	});
	/*----------------------------------------------------------------------------*/
	
	/*---------------------------------js sj_option_layout-------------------------------------------*/
	$('body').on('click','.sj_wrap_option_row .sj_column',function(){
		var parent = $(this).parent();
		var index = $(this).index();
		parent.find('.sj_column').removeClass('sj_column_active');
		$(this).addClass('sj_column_active');
		var element = parent.parent().parent().parent().parent().find('.content_column');
		var data_layout = $(this).attr('data-layout');
		element.empty();
		element.append(add_column(data_layout,1));
		//add_row_fuild($('.wrap_sj_content'),index);
	});
	/*----------------------------------------------------------------------------*/
		
		