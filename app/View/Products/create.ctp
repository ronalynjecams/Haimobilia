<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        height: 150,
        menubar: false,
        plugins: [
            'autolink',
            'link',
            'codesample',
            'lists',
            'searchreplace visualblocks',
            'table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample | link',
    });
</script>

<div class="content">
	<div class="container">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h4 class="page-title">Create Product</h4>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<input type="file" class="form-control" id="file_image" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="text" class="form-control" id="input_name" placeholder="Name" />
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<textarea id="input_description"></textarea>
					</div>
					
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<input type="number" step="any"
											onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"
											id="input_price"
											class="form-control"
											placeholder="Price" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<input type="number" step="any"
											onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57"
											id="input_sale_price"
											class="form-control"
											placeholder="Sale Price" />
							</div>
						</div>
					</div>
					
					<button class="btn btn-info" id="btn_create">
						<span class="fa fa-plus"></span>
						Create
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- JAVASCRIPT FUNCTIONS -->
<script>
$(document).ready(function() {
	$("button#btn_create").on('click', function() {
		var data = new FormData();

		//Append files infos
		jQuery.each($('input:file')[0].files, function(i, file) {
			data.append('Image', file);
		});

		$.ajax({  
			url: "/products/image_upload",  
			type: "POST",  
			data: data,  
			cache: false,
			processData: false,  
			contentType: false, 
			context: $('input:file'),
			success: function (msg) {
				console.log(msg);
				
				var name = $("#input_name");
				var description = $("#input_description");
				var image = $("#file_image");
				var price = $("#input_price");
				var sale_price = $("#input_sale_price");
				
			    var image_tmp = image.val().split('\\');
			    var image_filename = image_tmp[image_tmp.length-1];
				
				if(image.val()!="") {
					if(name.val()!="") {
						if(tinymce.get('input_description').getContent()!="") {
							if(price.val()!="") {
								if(sale_price.val()!="") {
									var data = {'name': name.val(),
											   'description': tinymce.get('input_description').getContent(),
											   'image': image_filename,
											   'price': price.val(),
											   'sale_price': sale_price.val()};
									$.ajax({
										url: '/products/add',
										type: 'POST',
										data: {"data": data},
										dataType: 'text',
										success: function(id) {
											console.log(id);
											location.reload();
										},
										error: function(err) {
											console.log("Ajax Result: Error in Products");
										}
									});
								}
								else {
									sale_price.css({'border-color':'red'});
								}
							}
							else {
								price.css({'border-color':'red'});
							}
						}
						else {
							description.css({'border-color':'red'});
						}
					}
					else {
						name.css({'border-color':'red'});
					}
				}
				else {
					image.css({'border-color':'red'});
				}
			},
			error: function (err) {
				console.log("Error with uploading image: "+err);
				alert("Error in uploading image: "+err);
			}
		});
	});
});
</script>
<!-- END JAVASCRIPT FUNCTIONS -->