<?php
/**
 * Created by PhpStorm.
 * User: Bakar U.A.
 * Date: 07-Jan-20
 * Time: 10:36 AM
 */
?>
<!--start acCharts JS-->
<script src="https://amcharts.com/lib/4/core.js"></script>
<script src="https://amcharts.com/lib/4/charts.js"></script>
<script src="https://amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://amcharts.com/lib/4/themes/kelly.js"></script>
<!--end amCharts JS-->

<script type="text/javascript">
    let parent = <?php echo $database->getArrayStates();?>;
    let child = <?php echo $database->getLGAofStates();?>;
    let gchild = <?php echo $database->getAreasofLGA();?>;
    function LoadChild(){
        let i = document.getElementById("parent").selectedIndex ;
        // let dp = document.getElementById("child");
        let dp2 = document.getElementById("gchild");
        //  let count = child[i-1].length;
        let count2 = gchild[i-1].length;

        //let html = "<option value=\"\" disabled selected hidden>- select -</option>";
        // for(let k = 0 ; k < count ; k ++){
        //     html += "<option value=\""+child[i-1][k][0]+"\">"+child[i-1][k][1]+"</option>";
        // }

        let html2 = "<option value=\"\" disabled selected hidden>- select -</option>";
        for(let k = 0 ; k < count2 ; k ++){
            html2 += "<option value=\""+gchild[i-1][k][0]+"\">"+gchild[i-1][k][1]+"</option>";
        }

        // dp.innerHTML = html;
        dp2.innerHTML = html2;
    }
</script>

<script>
    function isNumberKey(evt)
    {
        let charCode = (evt.which) ? evt.which : event.keyCode;
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
</script>
<script type="text/javascript">

    function Comma(Num)
    { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        let rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }

    function removeComma(args)
    {
        return args.replace(/,/g, "");
    }

</script>
<script>
    function validateNumber_Dot(s) {
        let rgx = /^[0-9]*\.?[0-9]*$/;
        return s.match(rgx);
    }

    function fun_AllowOnlyAmountAndDot(txt)
    {
        if(event.keyCode > 47 && event.keyCode < 58 || event.keyCode == 46)
        {
            let txtBox = document.getElementById(txt);
            let amount = document.getElementById(txt).value;
            let present=0;
            let count=0;

            if(amount.indexOf(".",present)||amount.indexOf(".",present+1));
            {
                // alert('0');
            }

            /*if(amount.length==2)
            {
              if(event.keyCode != 46)
              return false;
            }*/
            do
            {
                present=amount.indexOf(".",present);
                if(present!=-1)
                {
                    count++;
                    present++;
                }
            }
            while(present!=-1);
            if(present==-1 && amount.length==0 && event.keyCode == 46)
            {
                event.keyCode=0;
                //alert("Wrong position of decimal point not  allowed !!");
                return false;
            }

            if(count>=1 && event.keyCode == 46)
            {

                event.keyCode=0;
                //alert("Only one decimal point is allowed !!");
                return false;
            }
            if(count==1)
            {
                let lastdigits=amount.substring(amount.indexOf(".")+1,amount.length);
                if(lastdigits.length>=2)
                {
                    //alert("Two decimal places only allowed");
                    event.keyCode=0;
                    return false;
                }
            }
            return true;
        }
        else
        {
            event.keyCode=0;
            //alert("Only Numbers with dot allowed !!");
            return false;
        }
    }

</script>
<script type="text/javascript">
    let parentAccounts = <?php echo $database->getArrayAllAccounts();?>;
    let gChildMachines = <?php echo $database->getArrayOfMachines();?>;

    function LoadChildAccounts() {
        let i = document.getElementById("parent").selectedIndex;
        let dp2 = document.getElementById("gchild");
        let count2 = gChildMachines[i - 1].length;

        let html2 = "<option value=\"\" disabled selected hidden>- select -</option>";
        for (let k = 0; k < count2; k++) {
            html2 += "<option value=\"" + gChildMachines[i - 1][k][0] + "\">" + gChildMachines[i - 1][k][1] + "</option>";
        }
        dp2.innerHTML = html2;
    }

    function LoadChildMachines(selected) {
        let i = selected;
        let dp2 = document.getElementById("gchild");
        let count2 = gChildMachines[i - 1].length;

        let html2 = "<option value=\"\" disabled selected hidden>- select -</option>";
        for (let k = 0; k < count2; k++) {
            html2 += "<option value=\"" + gChildMachines[i][k][0] + "\">" + gChildMachines[i][k][1] + "</option>";
        }
        dp2.innerHTML = html2;
    }
</script>
<script type="text/javascript">
    function contractCheck() {
        let x_cost = document.getElementById("txtAmount");
        let x_machine = document.getElementById("gchild");
        let select_machine = x_machine.options[x_machine.selectedIndex].text;
        if (select_machine.indexOf("NC") + 1) {
            x_cost.value = "10,000";
            x_cost.disabled = false;
        } else {
            x_cost.value = "0";
            x_cost.disabled = true;
        }
        //x.disabled=(aList.selectedIndex == 0);
    }

    function init() {
        document.getElementById("txtMachine").selectedIndex = 1;
    }
</script>


