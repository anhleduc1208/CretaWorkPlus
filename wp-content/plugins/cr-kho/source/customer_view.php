<?php
    wp_enqueue_script('wp-api');
?>

<div>
    <div id="single_customer_view">
        <div class="jumbotron bg-info text-white" v-if="loading_flag">
            <h2>Chờ chút nhé!! Đang khởi tạo trang web ... {{count_up}}</h2>
        
        </div>
        <div class="jumbotron bg-warning text-white" v-if="error_flag">
            <h2>
                Có lỗi rồi! Thử tải lại trang xem sao :(
            </h2>
        </div>
        <!-- <h2>{{customer.code}}-{{customer.title.rendered}}</h2> -->
        <div v-if="customer.title">
            <div class="container p-3">
                <h1>{{ customer.title.rendered}}</h1>
            </div>
            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <!-- <th><h3><span class="align-middle">Mã khách hàng</h3></span></th> -->
                        <th><h3><span class="align-middle">Danh sách nhà xe</span></h3></th>
                    </tr>                
                </thead>
                <tbody>
                    <tr>
                        <!-- <td><h2>{{customer.code}}</h2></td> -->
                        <td>
                            <table v-for="(c,index) in customer.c_codes">
                                <tr>
                                    <td>                                    
                                        <div class="card bg-info text-white">
    
                                            <div class="card-body">
                                                Tên chành xe:
                                                <select v-model="c.code" class="form-control">
                                                    <option v-for="i in carriers" v-bind:value="i.code">{{i.code}} - {{i.title.rendered}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card bg-info text-white">
                                            
                                            <div class="card-body">Ghi chú:<textarea class="form-control" v-model="c.note"></textarea></div>
                                        </div>                                    
                                    </td>
                                    <td>
                                        <span class="align-bottom"><button v-on:click="delete_carrier_view(index)" class="btn-danger">X</button></span>
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button v-if="customer.code" class="btn-warning" v-on:click="new_carrier_view()">Thêm nhà xe</button>
                            </div>
                        </td>
                    </tr>
                </tbody>            
            </table>
            <div class="d-flex justify-content-end">
                <span>
                    <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#modalEdit">
                        Lưu thay đổi
                    </button>
                    <button type="button" class="btn btn-danger text-white" data-toggle="modal" data-target="#modalDelete">
                        Xóa khách hàng
                    </button>
                </span>
            </div>
        </div>
        <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEdit">Xác nhận lưu?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn thay đổi khách hàng này chứ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" v-on:click="submit_edit(customer)" data-dismiss="modal">Lưu thay đổi</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalActionStatus" tabindex="-1" role="dialog">
    <div></div>
</div>
        
    </div>

    <script>
        var app;
        var customer_code = <?php if(isset($_GET["code"])) {echo "'".$_GET["code"]."'";} else {echo "''";}?>;
        //console.log("customer_code",customer_code);
        $(document).ready(function(){
            app = new Vue({
                el: "#single_customer_view",
                data: {
                    id: 0,
                    count: 0,
                    customer: {},
                    carriers: [],
                    count_up: 0,
                    loading_flag: true,
                    error_flag: false
                },
                methods: {
                    run_clock: function(){
                        setInterval(() => {
                            app.count++;
                            if (app.count > 10){    
                                app.count = 0;
                            }
                        }, 100);
                    },
                    read_customer_by_code: function(e_code, cb){
                        var customer = new wp.api.collections.Customers();
                        customer.fetch({success: function(res){
                            //console.log(res);
                            for( i in res.models ){
                                //console.log(i);
                                if( res.models[i].attributes.code == e_code){
                                    cb({
                                        statusText: "OK",
                                        customer: res.models[i].attributes
                                    })
                                    //console.log(res.models[i]);
                                    return 0;
                                }
                            }
                        },error: function(){
                            cb({statusText: "ERROR"});
                        }})
                    },
                    read_customer_by_code_v2: function(e_code, cb){
                        $.ajax({
                            method: "GET",
                            url: "http://creta.work/wp-json/wp/v2/customers",
                            data: {"meta_key": "code", "meta_value": e_code},
                            dataType: "json",
                            success: function(data){
                                if (data[0]){
                                    if(data[0].c_codes == ""){
                                        data[0].c_codes = [];
                                    }
                                    cb({
                                    statusText: "OK",
                                    customer: data[0]
                                    });
                                } else {
                                    cb({
                                        statusText: "ERROR"
                                    })
                                }
                            },
                            error: function(){
                                cb({statusText: "ERROR"})
                            }
                        })
                    },
                    create_customer: function(){
                        //nothing to do here
                    },
                    edit_customer: function(e_id, e_customer, cb){
                        var customer = new wp.api.models.Customers({id: e_id});
                        customer.save(e_customer, {success: function(){
                            cb({statusText: "OK"});
                        }, error: function(){
                            cb({statusText: "ERROR"});
                        }})
                    },
                    delete_customer: function(e_id, cb){
                        var customer = new wp.api.models.Customers({id: e_id});
                        customer.destroy({success: function(){
                            cb({statusText: "OK"});
                        }, error: function(){
                            cb({statusText: "ERROR"});
                        }})
                    },
                    get_all_carriers: function(cb){
                        var carriers = new wp.api.collections.Carriers();
                        carriers.fetch({success: function(res){
                            var all_carriers = [];
                            for (i in res.models){
                                all_carriers.push(res.models[i].attributes);
                            }
                            cb({
                                statusText: "OK",
                                carriers: all_carriers
                            })
                        }, error: function(res){
                            cb({statusText: "OK"})
                        }})
                    },
                    get_all_carriers_v2: function(cb){
                        var r_carriers = [];
                        var that = this;
                        var carriers = new wp.api.collections.Carriers();
                        carriers.fetch({data: {per_page: 100}}).then(function(res){
                            r_carriers = res;
                            that.get_more_carrier_recursive(carriers, r_carriers, function(r_array){
                                cb({
                                    statusText: "OK",
                                    carriers: r_array
                                });
                            })
                        })
                    },
                    get_more_carrier_recursive: function(carriers, r_carriers, cb){
                        var that = this;
                        if(carriers.hasMore()){
                            carriers.more().then(function(res){
                                if( Array.isArray(res)){
                                    r_carriers = r_carriers.concat(res);
                                    that.get_more_carrier_recursive(carriers, r_carriers, cb);
                                }
                                else {
                                    cb(r_carriers);
                                }                                
                            })
                        }
                        else {
                            cb(r_carriers);
                        }
                    },
                    update_view_customer: function(){
                        if (customer_code == ""){
                            // alert("Please Enter code in Query!");
                        }
                        else {
                            var that = this;
                            that.read_customer_by_code_v2(customer_code, function(res){
                                if (res.statusText){
                                    if(res.statusText == "OK"){
                                        that.customer = res.customer;
                                        that.id = res.customer.id;
                                        that.loading_flag = false;
                                    }
                                    else if (res.statusText == "ERROR"){
                                        console.log("Error loading Customer", customer_code);
                                    }
                                    else {
                                        console.log("Error loading Customer", customer_code);
                                    }
                                }
                            })
                        }
                    },
                    new_carrier_view: function(){
                        var that = this;
                        that.customer.c_codes.push({
                            code: ""
                        })
                    },
                    delete_carrier_view: function(index){
                        //console.log("index",index);
                        var that = this;
                        that.customer.c_codes.splice(index, 1);
                    },
                    submit_edit: function(){
                        var that = this;
                        that.edit_customer(that.id, that.customer, function(res){
                            if (res.statusText){
                                if (res.statusText == "OK"){
                                    that.update_view_customer();
                                    that.action_status ="Lưu thành công!";
                                }
                                else {
                                    that.action_status ="Lưu thất bại!";
                                }
                            }
                        })
                    },
                    submit_delete: function(){
                        var that = this;
                        that.delete_customer(that.id,  function(res){
                            if (res.statusText){
                                if (res.statusText == "OK"){
                                    that.update_view_customer();
                                    that.action_status ="Xóa thành công!";
                                }
                                else {
                                    that.action_status ="Xóa thất bại!";
                                }
                            }
                        })
                    }
                },
                created: function(){
                    var that = this;
                    setTimeout(function(){
                        that.get_all_carriers_v2(function(res){
                            if (res.statusText){
                                if(res.statusText == "OK"){
                                    that.carriers = res.carriers;
                                    console.log("Success getting all Carriers");
                                }
                                else {
                                    console.log("Fail to get Carriers");
                                }
                            }
                        })
                        that.run_clock();
                        that.update_view_customer();
                    },2000);     
                    var count_up = setInterval(() => {
                        
                        if(that.loading_flag == true){
                            that.count_up++;
                            if(that.count_up >= 10){
                                that.error_flag = true;
                                that.loading_flag = false;
                            }
                        }
                        else {
                            clearInterval(count_up);
                        }
                    }, 1000);               
                },
                // components:{
                //     create_invoice_modal:{
                //         data: function(){
                //             return {
                //                 submit_invoice: {
                //                     slug: "",
                //                     status: "",
                //                     cr_invoice_status: "",
                //                     title: ""
                //                 }
                //             }
                //         },
                //         props: ["invoice"],
                //         template: `

                //         `
                //     },
                //     change_invoice_modal:{
                //         data: function(){
                //             return {

                //             }
                //         },
                //         props: [""],
                //         template: `
                            
                //         `
                //     }
                // }
            })
        });
        
    </script>
</div>