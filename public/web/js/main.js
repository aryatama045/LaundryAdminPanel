
var csrf = $('meta[name=csrf-token]').attr("content");
var base_url = $('meta[name=base_url]').attr("content");
var curr_url = window.location.origin+window.location.pathname;

// Loader start
$(function() {
    $(".preload").fadeOut(1000, function() {
        $(".for-loader").fadeIn(1000);
    });
});
// Loader end
// login start
jQuery(".form-control").on("blur", function() {
    if (jQuery(this).val().length <= 0) {
      jQuery(this)
        .siblings("label")
        .removeClass("moveUp");
      jQuery(this).removeClass("outline");
    }
    })
    .on("focus", function() {
    if (jQuery(this).val().length >= 0) {
      jQuery(this)
        .siblings("label")
        .addClass("moveUp");
      jQuery(this).addClass("outline");
    }
});
// login over

// Order status Change
function changeStatus(order_id)
{
    var con = "#selector"+order_id;
    var status = $(con).val();
    $.ajax({
        url: 'order/changeStatus',
        method: 'post',
        data: {order_id: order_id,status: status, _token: csrf},
        success: function(res) {
            if (status == 'Completed' || status == 'Cancel') {
                window.location.reload();
            }
        },
        error: function(error) {}
    });
}

$(document).ready(function ()
{
    // image upload new
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });

    function readURL_edit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview_edit').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview_edit').hide();
                $('#imagePreview_edit').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_edit").change(function() {
        readURL_edit(this);
    });

    function readURL_edit_2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview_edit_2').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview_edit_2').hide();
                $('#imagePreview_edit_2').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_edit_2").change(function() {
        readURL_edit_2(this);
    });

    function readURL_edit_3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview_edit_3').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview_edit_3').hide();
                $('#imagePreview_edit_3').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_edit_3").change(function() {
        readURL_edit_3(this);
    });

    function readURL_edit_4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview_edit_4').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview_edit_4').hide();
                $('#imagePreview_edit_4').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_edit_4").change(function() {
        readURL_edit_4(this);
    });

    function readURL_edit_5(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview_edit_5').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview_edit_5').hide();
                $('#imagePreview_edit_5').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_edit_5").change(function() {
        readURL_edit_5(this);
    });

    function readURL_edit_6(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview_edit_6').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview_edit_6').hide();
                $('#imagePreview_edit_6').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image_edit_6").change(function() {
        readURL_edit_6(this);
    });
    // end

    // Data Table Start
    $('#dataTableReport').DataTable({
        dom: 'Bfrtip',
        language: {
            paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>",
            first: "<i class='fa fa-angle-double-left'>",
            last: "<i class='fa fa-angle-double-right'>",
            }
        },
        buttons: [  'print',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
        ]
    });

    var revenueTable = $('#dataTableRevenueReport').DataTable({
        dom: 'Bfrtip',
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
        <'row'<'col-sm-12'tr>>
        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 'lp>>`,
        language: {
            paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>",
            first: "<i class='fa fa-angle-double-left'>",
            last: "<i class='fa fa-angle-double-right'>",
            }
        },
        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        columnDefs: [ {
            'targets': [5], /* column index */
            'orderable': false, /* true or false */
         }],
        pagingType: "full_numbers",
    });

    var usersTable = $('#dataTableUsersReport').DataTable({
        dom: 'Bfrtip',
        dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
        <'row'<'col-sm-12'tr>>
        <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 'lp>>`,
        language: {
            paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>",
            first: "<i class='fa fa-angle-double-left'>",
            last: "<i class='fa fa-angle-double-right'>",
            }
        },
        buttons: [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        columnDefs: [ {
            'targets': [1,9], /* column index */
            'orderable': false, /* true or false */
         }],
        pagingType: "full_numbers",
    });

    $('#export_print').on('click', function(e) {
        e.preventDefault();
        revenueTable.button(0).trigger();
        usersTable.button(0).trigger();
    });

    $('#export_copy').on('click', function(e) {
        e.preventDefault();
        revenueTable.button(1).trigger();
        usersTable.button(1).trigger();
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        revenueTable.button(2).trigger();
        usersTable.button(2).trigger();
    });

    $('#export_csv').on('click', function(e) {
        e.preventDefault();
        revenueTable.button(3).trigger();
        usersTable.button(3).trigger();
    });

    $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        revenueTable.button(4).trigger();
        usersTable.button(4).trigger();
    });

    // Data Table End

    // Chart Start
    // Admin Revenue chart
    if(curr_url == base_url+'/admin/dashboard') {
        initRevenueChart();
        $.ajax({
            url: 'revenueWeekData',
            method: 'get',
            success: function(data){
                updateRevenueChart(data);
            },
            error: function(err) {}
        })

        $('#yearRevenue').click(function() {
            $.ajax({
                url: 'revenueYearData',
                method: 'get',
                success: function(data){
                    updateRevenueChart(data);
                },
                error: function(err) {}
            })
        })

        $('#monthRevenue').click(function() {
            $.ajax({
                url: 'revenueMonthData',
                method: 'get',
                success: function(data){
                    updateRevenueChart(data);
                },
                error: function(err) {}
            })
        });

        $('#weekRevenue').click(function() {
            $.ajax({
                url: 'revenueWeekData',
                method: 'get',
                success: function(data){
                    updateRevenueChart(data);
                },
                error: function(err) {}
            })
        });

        var revenueChart;
        function initRevenueChart() {
            if(document.getElementById("revenue_chart")) {
                revenueChart = new Chart($('#revenue_chart'), {
                    type: 'line',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    color: Charts.colors.gray[200],
                                    zeroLineColor: Charts.colors.gray[200]
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (!(value % 10)) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    var label = data.datasets[item.datasetIndex].label || '';
                                    var yLabel = item.yLabel;
                                    var content = '';
                                    if (data.datasets.length > 1) {
                                        content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                    }
                                    content +=  '  ' + yLabel;
                                    return content;
                                }
                            }
                        }
                    },
                });
            }
        };

        function updateRevenueChart(data) {
            revenueChart.data =  {
                labels: data[1],
                datasets: [{
                    label: '',
                    data: data[0]
                }]
            };
            revenueChart.update();
            revenueChart.render({
                duration: 800,
                lazy: false,
            });
        }
    }
    // Admin Revenue Chart end
    // Admin Users chart Start
    if(curr_url == base_url+'/admin/dashboard')
    {
        $.ajax({
            url: 'userData',
            method: 'get',
            success: function(data){
                user_chart(data);
            },
            error: function(err) {}
        })
        function user_chart(data)
        {
            var OrdersChart = (function() {
            var $chart = $('#user_chart');
            function initUserChart($chart) {
                var userChart = new Chart($chart, {
                    type: 'bar',
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value) {
                                        if (!(value % 10)) {
                                            return value
                                        }
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(item, data) {
                                    var label = data.datasets[item.datasetIndex].label || '';
                                    var yLabel = item.yLabel;
                                    var content = '';
                                    if (data.datasets.length > 1) {
                                        content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                                    }
                                    content += '  ' + yLabel ;
                                    return content;
                                }
                            }
                        }
                    },
                    data: {
                        labels: data[1],
                        datasets: [{
                            label: 'User',
                            borderWidth: 1,
                            data: data[0]
                        }]
                    }
                });
                $chart.data('chart', userChart);
            }
            if ($chart.length) {
                initUserChart($chart);
            }
            })();
        }
    }
    // Admin Users chart End

    // Chart End
});

// Click to copy template

function copy_function(id){
    var value = document.getElementById(id).innerHTML;
    var input_temp = document.createElement("input");
    input_temp.value = value;
    document.body.appendChild(input_temp);
    input_temp.select();
    document.execCommand("copy");
    document.body.removeChild(input_temp);
};

// Role
$(".add_role").click(function (){
    $(".invalid-div span").html('');
    $("#add_role_sidebar").slideDown(50), $("#add_role_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_role_close").click(function (){
    $("#edit_role_sidebar").slideDown(50), $("#edit_role_sidebar").toggleClass("show_sidebar_edit")
});

// User
$(".add_user").click(function (){
    $(".invalid-div span").html('');
    $("#add_user_sidebar").slideDown(50), $("#add_user_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_user_close").click(function (){
    $("#edit_user_sidebar").slideDown(50), $("#edit_user_sidebar").toggleClass("show_sidebar_edit")
});

// Offer
$(".add_offer").click(function (){
    $(".invalid-div span").html('');
    $("#add_offer_sidebar").slideDown(50), $("#add_offer_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_offer_close").click(function (){
    $("#edit_offer_sidebar").slideDown(50), $("#edit_offer_sidebar").toggleClass("show_sidebar_edit")
});

$(".show_offer_close").click(function (){
    $("#show_offer_sidebar").slideDown(50), $("#show_offer_sidebar").toggleClass("show_sidebar")
});

// Service
$(".add_service").click(function (){
    $(".invalid-div span").html('');
    $("#add_service_sidebar").slideDown(50), $("#add_service_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_service_close").click(function (){
    $("#edit_service_sidebar").slideDown(50), $("#edit_service_sidebar").toggleClass("show_sidebar_edit")
});

$(".show_service_close").click(function (){
    $("#show_service_sidebar").slideDown(50), $("#show_service_sidebar").toggleClass("show_sidebar")
});

// Product
$(".add_product").click(function (){
    $(".invalid-div span").html('');
    $("#add_product_sidebar").slideDown(50), $("#add_product_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_product_close").click(function (){
    $("#edit_product_sidebar").slideDown(50), $("#edit_product_sidebar").toggleClass("show_sidebar_edit")
});

$(".show_product_close").click(function (){
    $("#show_product_sidebar").slideDown(50), $("#show_product_sidebar").toggleClass("show_sidebar")
});

// Coupon
$(".add_coupon").click(function (){
    $(".invalid-div span").html('');
    $("#add_coupon_sidebar").slideDown(50), $("#add_coupon_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_coupon_close").click(function (){
    $("#edit_coupon_sidebar").slideDown(50), $("#edit_coupon_sidebar").toggleClass("show_sidebar_edit")
});

$(".show_coupon_close").click(function (){
    $("#show_coupon_sidebar").slideDown(50), $("#show_coupon_sidebar").toggleClass("show_sidebar")
});

// language
$(".add_language").click(function (){
    $(".invalid-div span").html('');
    $("#add_language_sidebar").slideDown(50), $("#add_language_sidebar").toggleClass("show_sidebar_create")
});

$(".edit_language_close").click(function (){
    $("#edit_language_sidebar").slideDown(50), $("#edit_language_sidebar").toggleClass("show_sidebar_edit")
});
// Order


function template_edit(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        type:"get",
        url:base_url+'/admin/notification/template/edit/'+id,
        success: function(result){
            document.getElementById('temp_title').innerHTML = result.data.title;
            $(".form-group input[name='subject']").val(result.data.subject);
            $(".form-group input[name='msg_content']").val(result.data.msg_content);
            $("input[name='mail_content']").val(result.data.mail_content);

            $('#template_form .textarea_editor').data("wysihtml5").editor.setValue(result.data.mail_content);
            $('#template_form').get(0).setAttribute('action', base_url+'/admin/notification/template/update/'+result.data.id);
        },
        error: function(err){
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function all_create(formID,url) {

    var formData = new FormData($('#'+formID)[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        type:"POST",
        url:url,
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(result){
            if(result.success == true) {
                document.getElementById("create_btn").disabled = true;
                $.notify(result.msg, "success");
            }
            else{
                $.notify("Not Created..!!", "error");
            }
            setTimeout(function(){ location.reload(); }, 1200);
        },
        error: function(err){
            console.log('err ',err.responseJSON.errors)
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function all_edit(formID,url) {
    id = $("#"+formID+" input[name='id']").val();
    var formData = new FormData($('#'+formID)[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        type:"POST",
        url:url+'/'+id,
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success: function(result){
            if(result.success == true) {
                $.notify(result.msg, "success");
            }
            else {
                $.notify("Not Edited..!!", "error");
            }
            setTimeout(function(){ location.reload(); }, 1200);
        },
        error: function(err) {
            console.log('err ',err.responseJSON.errors)
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }

    });
}

function all_delete(url,id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't to delete this record!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                url: base_url+'/'+url+'/'+id,
                success: function (result) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                    Swal.fire({
                        type: 'success',
                        title: 'Deleted!',
                        text: 'Record is deleted successfully.',
                        showConfirmButton: false,
                    })
                },
                error: function (err) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'This record is conntect with another data!'
                    })
                }
            });
        }
    })
}

function edit_user(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'user/'+id+'/edit',
        success: function(result){
            $("#edit_user_sidebar").slideDown(50), $("#edit_user_sidebar").toggleClass("show_sidebar_edit");
            $(".invalid-div span").html('');
            $("#edit_user_sidebar input[name='name']").val(result.data.user.name);
            $("#edit_user_sidebar input[name='phone']").val(result.data.user.phone);
            $("#edit_user_sidebar input[name='email']").val(result.data.user.email);
            $("#edit_user_sidebar input[name='id']").val(result.data.user.id);
            $('#imagePreview_edit').css('background-image', 'url('+base_url+'/images/user/'+result.data.user.image+')');

            $('#edit_user_sidebar select[name="roles[]"] option').attr("selected",false);
            result.data.user.roles.forEach(element => {
                $('#edit_user_sidebar select[name="roles[]"] option[value='+element.id+']').attr("selected",true);
                $('#edit_user_sidebar select[name="roles[]"] option[value='+element.id+']').trigger('change');
            });
            var code = result.data.user.code.slice(1);
            $('#edit_user_sidebar select[name="country_code"] option').attr("selected",false);
            $('#edit_user_sidebar select[name="country_code"] option[value='+code+']').attr("selected",true);
            $('#edit_user_sidebar select[name="country_code"] option[value='+code+']').trigger('change');

            $('#edit_user_sidebar select[name="status"] option').attr("selected",false);
            $('#edit_user_sidebar select[name="status"] option[value='+result.data.user.status+']').attr("selected",true);
            $('#edit_user_sidebar select[name="status"] option[value='+result.data.user.status+']').trigger('change');
        },
        error: function(err){
            console.log(err);
        }
    });
}

function edit_role(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'role/'+id+'/edit',
        success: function(result){
            $(".invalid-div span").html('');
            $("#edit_role_sidebar input[name='title']").val(result.data.role.title);
            $("#edit_role_sidebar input[name='id']").val(result.data.role.id);

            $("#select_multiple").find('option').attr("selected",false);
            $("#select_multiple").val("");
            $("#select_multiple").trigger("change");
            result.data.role.permissions.forEach(element => {
                $('#edit_role_sidebar select[name="permission[]"] option[value='+element.id+']').attr("selected",true);
                $('#edit_role_sidebar select[name="permission[]"] option[value='+element.id+']').trigger('change');
            });
            $("#edit_role_sidebar").slideDown(50), $("#edit_role_sidebar").toggleClass("show_sidebar_edit");
        },
        error: function(err){}
    });
}

function edit_offer(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'offer/'+id+'/edit',
        success: function(result){
            $(".invalid-div span").html('');
            $("#edit_offer_sidebar input[name='id']").val(result.data.offer.id);
            $("#edit_offer_sidebar input[name='title1']").val(result.data.offer.title1);
            $("#edit_offer_sidebar input[name='title2']").val(result.data.offer.title2);
            $("#edit_offer_sidebar input[name='discount']").val(result.data.offer.discount);
            $('#imagePreview_edit').css('background-image', 'url('+base_url+'/images/offer/'+result.data.offer.image+')');

            $('#edit_offer_sidebar select[name="status"] option').attr("selected",false);
            $('#edit_offer_sidebar select[name="status"] option[value='+result.data.offer.status+']').attr("selected",true);
            $('#edit_offer_sidebar select[name="status"] option[value='+result.data.offer.status+']').trigger('change');

            $('#edit_offer_sidebar select[name="type"] option').attr("selected",false);
            $('#edit_offer_sidebar select[name="type"] option[value='+result.data.offer.type+']').attr("selected",true);
            $('#edit_offer_sidebar select[name="type"] option[value='+result.data.offer.type+']').trigger('change');

            $("#edit_offer_sidebar").slideDown(50), $("#edit_offer_sidebar").toggleClass("show_sidebar_edit");
        },
        error: function(err){}
    });
}

function edit_service(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'service/'+id+'/edit',
        success: function(result){
            $(".invalid-div span").html('');
            $("#edit_service_sidebar input[name='id']").val(result.data.service.id);
            $("#edit_service_sidebar input[name='name']").val(result.data.service.name);
            $("#edit_service_sidebar input[name='price']").val(result.data.service.price);
            $('#imagePreview_edit').css('background-image', 'url('+base_url+'/images/service/'+result.data.service.image+')');

            $('#edit_service_sidebar select[name="status"] option').attr("selected",false);
            $('#edit_service_sidebar select[name="status"] option[value='+result.data.service.status+']').attr("selected",true);
            $('#edit_service_sidebar select[name="status"] option[value='+result.data.service.status+']').trigger('change');

            $("#edit_service_sidebar").slideDown(50), $("#edit_service_sidebar").toggleClass("show_sidebar_edit");
        },
        error: function(err){}
    });
}

function edit_product(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'product/'+id+'/edit',
        success: function(result){
            $(".invalid-div span").html('');
            $("#edit_product_sidebar input[name='id']").val(result.data.product.id);
            $("#edit_product_sidebar input[name='name']").val(result.data.product.name);
            $("#edit_product_sidebar input[name='price']").val(result.data.product.price);
            $('#imagePreview_edit').css('background-image', 'url('+base_url+'/images/product/'+result.data.product.image+')');

            $("#select_multiple").find('option').attr("selected",false);
            $("#select_multiple").val("");
            $("#select_multiple").trigger("change");
            result.data.product.services.forEach(element => {
                $('#edit_product_sidebar select[name="service_id[]"] option[value='+element.id+']').attr("selected",true);
                $('#edit_product_sidebar select[name="service_id[]"] option[value='+element.id+']').trigger('change');
            });

            $('#edit_product_sidebar select[name="status"] option').attr("selected",false);
            $('#edit_product_sidebar select[name="status"] option[value='+result.data.product.status+']').attr("selected",true);
            $('#edit_product_sidebar select[name="status"] option[value='+result.data.product.status+']').trigger('change');

            $("#edit_product_sidebar").slideDown(50), $("#edit_product_sidebar").toggleClass("show_sidebar_edit");
        },
        error: function(err){}
    });
}

function edit_coupon(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'coupon/'+id+'/edit',
        success: function(result){
            $(".invalid-div span").html('');
            $("#edit_coupon_sidebar input[name='id']").val(result.data.coupon.id);
            $("#edit_coupon_sidebar input[name='code']").val(result.data.coupon.code);
            $("#edit_coupon_sidebar input[name='max_use']").val(result.data.coupon.max_use);
            $("#edit_coupon_sidebar input[name='discount']").val(result.data.coupon.discount);
            var duration  = [result.data.coupon.start_date,result.data.coupon.end_date];
            $("#filter_date_edit").flatpickr({
                mode: "range",
                dateFormat: "Y-m-d",
                showMonths:2,
                defaultDate: duration,
            });

            $('#edit_coupon_sidebar select[name="status"] option').attr("selected",false);
            $('#edit_coupon_sidebar select[name="status"] option[value='+result.data.coupon.status+']').attr("selected",true);
            $('#edit_coupon_sidebar select[name="status"] option[value='+result.data.coupon.status+']').trigger('change');

            $('#edit_coupon_sidebar select[name="type"] option').attr("selected",false);
            $('#edit_coupon_sidebar select[name="type"] option[value='+result.data.coupon.type+']').attr("selected",true);
            $('#edit_coupon_sidebar select[name="type"] option[value='+result.data.coupon.type+']').trigger('change');

            $("#edit_coupon_sidebar").slideDown(50), $("#edit_coupon_sidebar").toggleClass("show_sidebar_edit");
        },
        error: function(err){}
    });
}

function edit_language(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'language/'+id+'/edit',
        success: function(result){
            $(".invalid-div span").html('');
            $("#edit_language_sidebar input[name='id']").val(result.data.language.id);
            $("#edit_language_sidebar input[name='name']").val(result.data.language.name);
            $('#imagePreview_edit').css('background-image', 'url('+base_url+'/images/language/'+result.data.language.image+')');

            $('#edit_language_sidebar select[name="direction"] option').attr("selected",false);
            $('#edit_language_sidebar select[name="direction"] option[value='+result.data.language.direction+']').attr("selected",true);
            $('#edit_language_sidebar select[name="direction"] option[value='+result.data.language.direction+']').trigger('change');

            $('#edit_language_sidebar select[name="status"] option').attr("selected",false);
            $('#edit_language_sidebar select[name="status"] option[value='+result.data.language.status+']').attr("selected",true);
            $('#edit_language_sidebar select[name="status"] option[value='+result.data.language.status+']').trigger('change');

            $("#edit_language_sidebar").slideDown(50), $("#edit_language_sidebar").toggleClass("show_sidebar_edit");
        },
        error: function(err){}
    });
}
function show_offer(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'offer/'+id,
        success: function(result){
            document.getElementById('offer_type_percentage').innerHTML = "";
            document.getElementById('offer_type_amount').innerHTML = "";

            $('#show_offer_sidebar .offer_img').attr('src', base_url+'/images/offer/'+result.data.offer.image);
            document.getElementById('offer_title1').innerHTML = result.data.offer.title1;
            document.getElementById('offer_title2').innerHTML = result.data.offer.title2;
            document.getElementById('offer_discount').innerHTML = result.data.offer.discount;
            if (result.data.offer.type == "Percentage") {
                document.getElementById('offer_type_percentage').innerHTML = "%";
            }
            if (result.data.offer.type == "Amount") {
                document.getElementById('offer_type_amount').innerHTML = result.data.currency_symbol;
            }
            if (result.data.offer.status == 1) {
                document.getElementById('offer_status').innerHTML = "Active";
            }
            else {
                document.getElementById('offer_status').innerHTML = "Inactive";
            }
            $("#show_offer_sidebar").slideDown(50), $("#show_offer_sidebar").toggleClass("show_sidebar");
            $('#show_offer_sidebar .edit_offer_btn').attr('onClick', 'edit_offer('+result.data.offer.id+')');
        },
        error: function(err){}
    });
}

function show_service(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'service/'+id,
        success: function(result) {
            $('#show_service_sidebar .service_img').attr('src', base_url+'/images/service/'+result.data.service.image);
            document.getElementById('service_name').innerHTML = result.data.service.name;
            document.getElementById('price1').innerHTML = result.data.currency_symbol +""+ result.data.service.price +"/"+result.data.cloth_unit;

            if (result.data.service.status == 1) {
                document.getElementById('service_status').innerHTML = "Active";
            } else {
                document.getElementById('service_status').innerHTML = "Inactive";
            }
            $("#show_service_sidebar").slideDown(50), $("#show_service_sidebar").toggleClass("show_sidebar");
            $('#show_service_sidebar .edit_service_btn').attr('onClick', 'edit_service('+result.data.service.id+')');
        },
        error: function(err){}
    });
}

function show_product(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'product/'+id,
        success: function(result){
            $('#show_product_sidebar .product_img').attr('src', base_url+'/images/product/'+result.data.product.image);
            document.getElementById('product_name').innerHTML = result.data.product.name;
            document.getElementById('product_price').innerHTML = result.data.currency_symbol +""+ result.data.product.price +"/"+result.data.cloth_unit;


            let arr = []
            var append = ""
            var ser_arr = result.data.product.services

            for (let i = 0; i < ser_arr.length; i++) {
                arr.push(ser_arr[i].name)
                var temp = arr[i]
                append += temp+"<br>"
            }
            $('#all_services').html(append)
            if (result.data.product.status == 1) {
                document.getElementById('product_status').innerHTML = "Active";
            } else {
                document.getElementById('product_status').innerHTML = "Inactive";
            }
            $("#show_product_sidebar").slideDown(50), $("#show_product_sidebar").toggleClass("show_sidebar");
            $('#show_product_sidebar .edit_product_btn').attr('onClick', 'edit_product('+result.data.product.id+')');
        },
        error: function(err){}
    });
}

function show_coupon(id) {
    $.ajax({
        headers: {
            'XCSRF-TOKEN': csrf
        },
        type:"GET",
        url:'coupon/'+id,
        success: function(result){
            document.getElementById('coupon_code').innerHTML = result.data.coupon.code;
            document.getElementById('coupon_max_use').innerHTML = result.data.coupon.max_use;
            document.getElementById('coupon_use_count').innerHTML = result.data.coupon.use_count;
            document.getElementById('coupon_type').innerHTML = result.data.coupon.type;
            document.getElementById('coupon_start_date').innerHTML = result.data.coupon.start_date;
            document.getElementById('coupon_end_date').innerHTML = result.data.coupon.end_date;
            if (result.data.coupon.type == "Percentage") {
                document.getElementById('coupon_discount').innerHTML = result.data.coupon.discount+'%';
            } else{
                document.getElementById('coupon_discount').innerHTML = result.data.symbol+result.data.coupon.discount;
            }
            if (result.data.coupon.status == 1) {
                document.getElementById('coupon_status').innerHTML = "Active";
            } else{
                document.getElementById('coupon_status').innerHTML = "Inactive";
            }
            $("#show_coupon_sidebar").slideDown(50), $("#show_coupon_sidebar").toggleClass("show_sidebar");
            $('#show_coupon_sidebar .edit_coupon_btn').attr('onClick', 'edit_coupon('+result.data.coupon.id+')');
        },
        error: function(err){}
    });
}
