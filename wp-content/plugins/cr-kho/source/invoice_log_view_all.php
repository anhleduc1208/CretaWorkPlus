<div class="w3-responsive w3-container" style="color:black">
    <h3 class="w3-center">Lịch sử log các hóa đơn gần đây của CRETA</h3>

    </br>
   

    <div id="choose_what_to_query" class="w3-display-container">
        <form class="w3-display-middle">
            <select id="myChoice" onchange="levelChoose()">
                <option value="1" selected>Tất cả</option>
                <option value="Normal">Normal</option>
                <option value="Warning">Warning</option>  
                <option value="Error">Error</option>                              
            </select>
        </form>
    </div>

    </br>

    <div id="invoices_view">
        <table id="table_view" class="w3-table-all w3-bordered w3-striped ">         
            
        </table>
    </div>    

</div>

<script>
    getLogs(1);
    //var i = 0;
    setInterval(updateTable,20000);
    
    function updateTable(){
        var choi = document.getElementById("myChoice").value;
        getLogs(choi);        
    }

    function levelChoose(){
        var choice = document.getElementById("myChoice").value;
        getLogs(choice);
    }
    
    function getLogs(str){
        var xhttp = new XMLHttpRequest();
        var url = "";
        if (str == 1) {
            url = "http://creta.work/wp-json/wp/v2/logs?_fields=id,code,datetime,description,dangerousLevel&per_page=100&meta_key=type&meta_value=cr_invoice";
        } else {
            url = "http://creta.work/wp-json/wp/v2/logs?_fields=id,code,datetime,description,dangerousLevel&per_page=40&meta_key=type&meta_value=cr_invoice&meta_key=dangerousLevel&meta_value=" + str;
        }        
        var data ="";
        var dataOBJ;
        
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                data = this.responseText;
                dataOBJ = JSON.parse(data);
                drawTable(dataOBJ);
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
        
    }
    function drawTable(obj) {
        var tbl_element = document.getElementById("table_view");        
        var txt="";
        var cnt = obj.length;
        var i=0;
        txt += "<tr class='w3-khaki '>";
        txt += "<th class='w3-center'>Mã đơn</th>";
        txt += "<th class='w3-center'>Thời gian</th>";
        txt += "<th class='w3-center'>Tình trạng</th>";
        txt += "<th class='w3-center'>Chi tiết</th>";  
        txt += "<th class='w3-center'>Tra cứu</th>";     
        txt += "</tr>"; 

        for (i=0; i<cnt;i++){
            var single_log = obj[i];
            var logCode = single_log.code;
            var logDatetime = single_log.datetime;
            var logDescription = single_log.description;            
            var logLevel = single_log.dangerousLevel;
            var color;
            switch (logLevel) {
                case 'Normal':
                    color= "green";
                    break;
                case 'Warning':
                    color= "yellow";
                    break;
                case 'Error':
                    color= "red";
                    break;
                default:
            }
            var btnLink = "http://creta.work/invoice-single-detail/?code="+ logCode;
            var btnName = "Chi tiết HĐ";

           

            txt += "<tr class='w3-pale-"+color+"'>";
            txt += "<td class='w3-center'>" + logCode + "</td>";

            txt += "<td class='w3-center'>" + logDatetime + "</td>"; 
            txt += "<td class='w3-center w3-" + color + "'> "+ logLevel + "</td>";
            txt += "<td class='w3-center'>" + logDescription + "</td>";

            

            txt += "<td class='w3-center'>";
            txt += "<a  href='" + btnLink + "'><button class='w3-button w3-"+color+" w3-round '>"+btnName+ "</button></a>";
            txt += "</td>";
            
            
            txt += "</tr>";
        }

        


        tbl_element.innerHTML = txt;
    }

</script>