</div> <!-- container -->
</div> <!-- content -->
<footer class="footer text-left" id="titleFooter">
    2015 © Moltran.
</footer>
</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
</div>
<!-- END wrapper -->



<script>
	var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?=base_url().'assets/assets/'?>js/waves.js"></script>
<script src="<?=base_url().'assets/assets/'?>js/wow.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/assets/'?>js/jquery.scrollTo.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/jquery-detectmobile/detect.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/fastclick/fastclick.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/jquery-blockui/jquery.blockUI.js"></script>
<!-- sweet alerts -->
<script src="<?=base_url().'assets/assets/'?>assets/sweetalert2/sweetalert2.all.js"></script>
<!-- Counter-up -->
<script src="<?=base_url().'assets/assets/'?>assets/counterup/waypoints.min.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/assets/'?>assets/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<!-- CUSTOM JS -->
<script src="<?=base_url().'assets/assets/'?>js/jquery.app.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/tagsinput/jquery.tagsinput.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/toggles/toggles.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/colorpicker/bootstrap-colorpicker.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/bootstrap3-editable/bootstrap-editable.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/jquery-multi-select/jquery.multi-select.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/jquery-multi-select/jquery.quicksearch.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/assets/'?>assets/spinner/spinner.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/select2/select2.min.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/assets/'?>assets/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/timepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/datatables/dataTables.bootstrap.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/responsive-table/rwd-table.min.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/assets/'?>assets/notifications/notify.min.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/notifications/notify-metro.js"></script>
<script src="<?=base_url().'assets/assets/'?>assets/notifications/notifications.js"></script>
<!-- jvectormap -->

<script type="text/javascript">


 
	document.addEventListener("mousewheel", function(event){
		if(document.activeElement.type === "number"){
			document.activeElement.blur();
		}
	});
	
	$(document).ready(function () {
		$('.table-responsive').on('show.bs.dropdown', function () {
			document.querySelector('style').textContent += "@media only screen and (max-width: 500px) {.dropdown-menu {position: relative !important}} @media only screen and (min-width: 500px) {.table-responsive {overflow: inherit !important;}}";
		}).on('hide.bs.dropdown', function () {
			document.querySelector('style').textContent += "@media only screen and (min-width: 500px) {.table-responsive {overflow: auto !important}}";
		})
	});
	
	jQuery(document).ready(function($) {
		/*$("#dw").datetimepicker({
			format: 'YYYY-MM-DD'
		});

		//Get the value of Start and End of Week
		$('#dw').on('dp.change', function (e) {
			value = $("#dw").val();
			firstDate = moment(value, "YYYY-MM-DD").day(0).format("YYYY-MM-DD");
			lastDate =  moment(value, "YYYY-MM-DD").day(6).format("YYYY-MM-DD");
			$("#dw").val(firstDate + "   -   " + lastDate);
		});*/
		$('#datatable').DataTable();
		
		$('.datatable').DataTable();
		
		$('.counter').counterUp({
			delay: 100,
			time: 1200
		});
		
		// Tags Input
		jQuery('#tags').tagsInput({width:'auto'});
		
		// Form Toggles
		jQuery('.toggle').toggles({on: true});
		
		// Time Picker
		jQuery('#timepicker').timepicker({defaultTIme: false});
		jQuery('#timepicker2').timepicker({showMeridian: false});
		jQuery('#timepicker3').timepicker({minuteStep: 15});
		
		// Date Picker
		jQuery('.datepicker').datepicker();
		jQuery('.datepicker-inline').datepicker();
		jQuery('.datepicker-multiple').datepicker({
			numberOfMonths: 3,
			showButtonPanel: true
		});
		
		
		$('.datetimerange').daterangepicker(
			{
				timePicker: true,
				timePicker24Hour: true,
				timePickerIncrement: 5,
				locale: {
					format: 'YYYY-MM-DD H:mm'
				},
				startDate: moment(),
				endDate: moment()
			}
		);
		
		//colorpicker start
		$('.colorpicker-default').colorpicker({
			format: 'hex'
		});
		$('.colorpicker-rgba').colorpicker();
		
		
		//multiselect start
		
		$('#my_multi_select1').multiSelect();
		$('#my_multi_select2').multiSelect({
			selectableOptgroup: true
		});
		
		$('#my_multi_select3').multiSelect({
			selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
			selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
			afterInit: function (ms) {
				var that = this,
					$selectableSearch = that.$selectableUl.prev(),
					$selectionSearch = that.$selectionUl.prev(),
					selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
					selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';
				
				that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
					.on('keydown', function (e) {
						if (e.which === 40) {
							that.$selectableUl.focus();
							return false;
						}
					});
				
				that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
					.on('keydown', function (e) {
						if (e.which == 40) {
							that.$selectionUl.focus();
							return false;
						}
					});
			},
			afterSelect: function () {
				this.qs1.cache();
				this.qs2.cache();
			},
			afterDeselect: function () {
				this.qs1.cache();
				this.qs2.cache();
			}
		});
		
		$('input[name=day]').datepicker( {
			format: "yyyy-mm-dd",
			minViewMode: 3,
			autoclose: true
		} );
		
		$('input[name=year]').datepicker( {
			format: "yyyy",
			minViewMode: 2,
			autoclose: true
		} );
		
		$('input[name=month]').datepicker( {
			format: "MM, yyyy",
			minViewMode: 1,
			autoclose: true
		} );
		
		$('input[name=week]').datepicker( {
			format: "yyyy-mm-dd",
			autoclose: true
		}).on('show', function(e){
			
			var tr = $('body').find('.datepicker-days table tbody tr');
			
			tr.mouseover(function(){
				$(this).addClass('week');
			});
			
			tr.mouseout(function(){
				$(this).removeClass('week');
			});
			
			calculate_week_range(e);
			
		}).on('hide', function(e){
			console.log('date changed');
			calculate_week_range(e);
		});
		
		var calculate_week_range = function(e){
			
			var input = e.currentTarget;
			
			// remove all active class
			$('body').find('.datepicker-days table tbody tr').removeClass('week-active');
			
			// add active class
			var tr = $('body').find('.datepicker-days table tbody tr td.active.day').parent();
			tr.addClass('week-active');
			
			// find start and end date of the week
			
			var date = e.date;
			var start_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
			var end_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
			
			// make a friendly string
			
			var friendly_string = start_date.getFullYear() + '-' + (start_date.getMonth() + 1) + '-' + start_date.getDate()  + ' to '
				+ end_date.getFullYear() + '-' + (end_date.getMonth() + 1) + '-' + end_date.getDate();
			
			console.log(friendly_string);
			
			$(input).val(friendly_string);
			
		};
		
		$('.input-daterange').datepicker({
			format: "yyyy-mm-dd"
		});
		
		//spinner start
		$('#spinner1').spinner();
		$('#spinner2').spinner({disabled: true});
		$('#spinner3').spinner({value:0, min: 0, max: 10});
		$('#spinner4').spinner({value:0, step: 5, min: 0, max: 200});
		//spinner end
		
		// Select2
		jQuery(".select2").select2({
			width: '100%'
		});
	});
	
	$('.datepicker_date_from').datepicker({
		format: 'yyyy-mm-dd'
	}).on( "change", function() {
		$('.datepicker_date_to').datepicker({
			format: 'yyyy-mm-dd',
			startDate: get_date($(".datepicker_date_from").val())+'d'
		});
	});
	
	setTimeout(function(){
		$('.delay_datepicker_date_from').datepicker({
			format: 'yyyy-mm-dd'
		}).on( "change", function() {
			$('.datepicker_date_to').datepicker({
				format: 'yyyy-mm-dd',
				startDate: get_date($(".delay_datepicker_date_from").val())+'d'
			});
		});
	}, 2000);
	
	/*date range*/
	function get_daterange(type) {
		var output = null;
		$.ajax({
			url: "<?php echo base_url().'welcome/get_session_date/'?>" + type,
			type: "GET",
			async: false,
			success: function (res) {
				output = res;
			}
		});
		return output;
	}
	
	var startDate = get_daterange('startDate');
	var endDate = get_daterange('endDate');

    $('#ymrange').daterangepicker({
        "showDropdowns": true,
        "ranges": {
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
            'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        },
        "alwaysShowCalendars": true,
        "startDate": startDate,
        "endDate": endDate,
        "maxDate": moment(),
        "opens": "right"
    }, function(start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM') + ' to ' + end.format('YYYY-MM') + ' (predefined range: ' + label + ')');
        $('#field-date').val(start.format('YYYY-MM') + ' - ' + end.format('YYYY-MM'));
        after_change(start.format('YYYY-MM') + ' - ' + end.format('YYYY-MM'));
    });


	$('#daterange').daterangepicker({
		"showDropdowns": true,
		"ranges": {
			'Hari Ini': [moment(), moment()],
			'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
			'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
			'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
			'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
			'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
			'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
		},
		"alwaysShowCalendars": true,
		"startDate": startDate,
		"endDate": endDate,
		"maxDate": moment(),
		"opens": "right"
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$('#field-date').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
		after_change(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
	});
	
	$('#daterange_all').daterangepicker({
		"showDropdowns": true,
		"ranges": {
			'Hari Ini': [moment(), moment()],
			'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
			'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
			'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
			'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
			'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
			'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
		},
		"alwaysShowCalendars": true,
		"startDate": startDate,
		"endDate": endDate,
		//"maxDate": moment(),
		"opens": "right"
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$('#field-date').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
		after_change(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
	});
	$('.daterangesingle').daterangepicker(
		{
			showDropdowns: true,
			locale: {
				format: 'YYYY-MM-DD'
			},
			singleDatePicker: true,
			startDate: moment()
			
		}
	);
	$('#daterange-right').daterangepicker({
		"showDropdowns": true,
		"ranges": {
			'Hari Ini': [moment(), moment()],
			'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
			'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
			'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
			'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
			'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
			'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
		},
		"alwaysShowCalendars": true,
		"startDate": startDate,
		"endDate": endDate,
		"maxDate": moment(),
		"opens": "left"
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$('#field-date').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
		after_change(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
		
		
	});
	
	function get_date(tanggal) {
		var sekarang = new Date();
		var pembanding = sekarang.getFullYear()+("0" + (sekarang.getMonth() + 1)).slice(-2)+("0" + (sekarang.getDate())).slice(-2);
		var get_selisih = parseInt(tanggal.replace(/-/g,'')) - parseInt(pembanding);
		
		if (get_selisih <= 0) {
			selisih = get_selisih.toString();
		} else {
			selisih = "+" + get_selisih.toString();
		}
		
		return selisih;
	}
	
	function set_date(periode, type) {
		var date = periode.split(" - ");
		if (type == 'datetimerange') {
			$('.'+type).daterangepicker(
				{
					timePicker: true,
					timePicker24Hour: true,
					timePickerIncrement: 5,
					locale: {
						format: 'YYYY-MM-DD H:mm'
					},
					startDate: date[0],
					endDate: date[1]
				}
			);
		} else if (type == 'daterangesingle') {
			$('.'+type).daterangepicker(
				{
					showDropdowns: true,
					locale: {
						format: 'YYYY-MM-DD'
					},
					singleDatePicker: true,
					startDate: moment(date[0]).format('YYYY-MM-DD')
				}
			);
		} else if (type == 'daterange') {
			$('.'+type).daterangepicker(
				{
					locale: {
						format: 'YYYY-MM-DD'
					},
					startDate: moment(date[0]).format('YYYY-MM-DD'),
					endDate: moment(date[1]).format('YYYY-MM-DD')
				}
			);
		} else if (type == 'daterange2') {
			$('.'+type).daterangepicker(
				{
					ranges: {
						'Hari Ini': [moment(), moment()],
						'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
						'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
						'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
						'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
						'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
						'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
						'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
						'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
						'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
					},
					locale: {
						format: 'YYYY-MM-DD'
					},
					startDate: moment(date[0]).format('YYYY-MM-DD'),
					endDate: moment(date[1]).format('YYYY-MM-DD')
				}
			);
		}
	}


</script>



</body>
</html>