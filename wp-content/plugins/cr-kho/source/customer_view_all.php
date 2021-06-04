<div class="jumbotron jumbotron-fluid" id="customer_view_all">
    <div class="card">
        <div class="card-header">
            <h3> Tra cứu thông tin chành xe: </h3>
        <div class="card-body">
            <h5>Nhập mã khách hàng (Ví dụ: KH000534)</h5>
            <input type="text" v-model="code" class="form-control">
            <button v-on:click="redirect(code)">Xác nhận</button>
            <span v-if="empty_flag" class="text-danger" placeholder="VD: KH000534">Mã khách hàng không được để trống!</span>
        </div>  
    </div>
</div>
<script>
    var app;
    $(document).ready(function(){
        app = new Vue({
            el: "#customer_view_all",
            data: {
                code: "",
                empty_flag: false
            },
            methods: {
                redirect: function(code){
                    var that = this;
                    if(code == ""){
                        that.empty_flag = true;
                    }
                    else {
                        window.location.href = "/khach-hang-danh-sach?code=" + code;
                    }
                }
            }
        })
    })
</script>