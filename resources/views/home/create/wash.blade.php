@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title">Cucian Baru</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<form action="{{ route('home.store.wash') }}" method="post" id="createWashForm" role="form">
		{{ csrf_field() }}
		<div class="form-group row">
			<input type="hidden" id="inputtype2" name="type" value="1">
			<div class="col-6">
				<button id="umum-type-btn2" class="btn btn-block btn-outline-info active" type="button">
					Umum
				</button>
			</div>
			<div class="col-6">
				<button id="karyawan-type-btn2" class="btn btn-block btn-outline-info" type="button">
					Karyawan
				</button>
			</div>
		</div>
		<div id="worker-description2" class="form-group row" hidden>
			<label for="inputdescription2" class="col-5 col-form-label">Keterangan Karyawan</label>
			<div class="col-7">
				<input type="text" id="inputdescription2" name="description" value="{{ old('description') }}" class="form-control" autocomplete="off">
			</div>
		</div>
		<div class="form-group row">
			<label for="inputwashdescription" class="col-5 col-form-label">Keterangan Kendaraan</label>
			<div class="col-7">
				<input type="text" id="inputwashdescription" name="washdescription" value="{{ old('description') }}" class="form-control" required autocomplete="off">
			</div>
		</div>
		<div class="form-group">
			<hr>
		</div>
		<div class="form-group">
			<h3>Tarif <small>= <span id="modal-total">0</span></small></h3>
			<div id="washing-rates"></div>
		</div>
		<div class="form-group row">
			<div class="col-3 mb-3">
				<label for="washing-rate-id" class="col-form-label">
					Tambah Tarif
				</label>
			</div>
			<div class="col-7 mb-3">
				<select name="washing_rate" id="washing-rate-id" class="form-control">
					@foreach($washing_rates as $washing_rate)
						<option value="{{ $washing_rate->id }}" data-price="{{ $washing_rate->price }}" data-name="{{ $washing_rate->name }}">{{ $washing_rate->name.' ('.indo_currency($washing_rate->price).')'}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-2 mb-3">
				<button id="add-rate-btn" class="btn btn-block btn-success" type="button">
					<span class="fa fa-plus"></span>
				</button>
			</div>
		</div>
		<div id="select-mechanics" hidden class="form-group">
			<h3>Mekanik</h3>
			@foreach($mechanics as $mechanic)
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input type="checkbox" class="form-check-input mechanic_id" name="mechanic_id[]" value="{{ $mechanic->id }}">
						{{ $mechanic->name }}
					</label>
				</div>
			@endforeach
		</div>
	</form>
</div>
<div class="modal-footer">
	<div class="col">
		<button id="submit-btn" form="createWashForm" class="btn btn-block btn-primary" type="submit">
			<span class="fa fa-check"></span> Buat
		</button>
	</div>
	<div class="col">
		<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" aria-label="Close">
			<span class="fa fa-times"></span> Batal
		</button>
	</div>
</div>
<script>
	var mechanic_id = [],
		mechanic_required = 0,
		washing_rate_id = [],
		price_total = 0;

	$("#umum-type-btn2").click(function() {
		$(this).addClass('active');
		$("#karyawan-type-btn2").removeClass('active');
		$("#inputtype2").val('Umum');
		$("#worker-description2").attr('hidden', 'hidden').find('#inputdescription2').removeAttr('required');
	});

	$("#karyawan-type-btn2").click(function() {
		$(this).addClass('active');
		$("#umum-type-btn2").removeClass('active');
		$("#inputtype2").val('Karyawan');
		$("#worker-description2").removeAttr('hidden').find('#inputdescription2').attr('required', 'required');
	});

	$("#washModal").on('shown.bs.modal', function () {
		$(this).attr('aria-label', $("#modal-title").html());
		$("#inputwashdescription").focus();
	});

	$("#add-rate-btn").click(function(e) {
		var text = $("#washing-rate-id").find('option:selected').text(),
			price = parseInt($("#washing-rate-id").find('option:selected').data('price')),
			name = $("#washing-rate-id").find('option:selected').data('name'),
			val = $("#washing-rate-id").val();
		$("#washing-rates").append(
			"<div class='form-group'>" +
			"<input type='hidden' name='washing_rate_id[]' class='washing_rate_id' value='"+val+"'>" +
			"<input class='form-control' value='"+text+"' readonly>" +
			"</div>"
		);
		price_total += price;
		$("#modal-total").html(price_total.toLocaleString());

		if(name == 'Salon') {
			$("#select-mechanics").removeAttr('hidden');
			mechanic_required = 1;
		}
		console.log(mechanic_required);
	});

	$("#createWashForm").submit(function(e) {
		if(mechanic_required == 1 && $("input.mechanic_id:checked").length == 0) {
			e.preventDefault();
			alert('Anda belum memilih mekanik');
		}
		else if($("input.washing_rate_id").length == 0) {
			e.preventDefault();
			alert('Anda belum memilih tarif');
		}
	});
</script>
