<?php
  require "common_functions.php";

  $log_file = "treats.log";
  $fp = fopen($log_file,'w');

  $sessionId = session_id();
  echo "<!--sessionId-".$sessionId."-->\n";

?>
      <link rel="stylesheet" type="text/css" href="css/overlay.css">
      <script src=js/changePages.js></script>
      <table id='mainTable'>
        <col style="width: 250px;">
        <col style="width: 250px;">
        <tr>
          <td colspan="3" style="text-align: center;"><h2>Sugar Shack Treats</h2></td>
        </tr>
        <!--tr>
          <td id='tdHead20' style="text-align: center;"></td>
          <td id='tdHead21' style="text-align: center;"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" style="text-align: center;">&nbsp;</td>
        </tr-->
        <!--TR_EMPTY-->
        <tr>
          <td style='text-align: left; vertical-align: top'>
            <lable for='cakeSize'>Cake Size: </lable>
            <select id='cakeSize' name='cakeSize' onchange='changeSize()'>
            </select>
          </td>
          <td style='text-align: left; vertical-align: top'>
            <lable for='cakeQty'>Qty: </label>
            <input type='number' id='cakeQty' name='cakeQty' min='10' max='100' onchange='changeSize()'>
          </td>
	  <td style='text-align: left; vertical-align: top'>
            <lable for='cakePrice'>Price: </label>
            <input type='text' id='cakePrice' name='cakePrice' readonly>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td id='cakeQtyMsg' name='cakeQtyMsg'>Between 10 and 100<b>(What is max?)</b></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td style='text-align: left; vertical-align: top'>
            <lable for='partyType'>Type: </lable>
            <select id='partyType' name='partyType'>
              <option selected value='0'>Choose an option</option>
              <option value='1'>Kids Party</option>
              <option value='1'>Employee Party</option>
              <option value='1'>Retirement Party</option>
              <option value='1'>House Party</option>
              <option value='1'>Weddings</option>
              <option value='1'>Custom Party</option>
            </select>
          </td>
          <td style='text-align: left; vertical-align: top'>
            <lable for='partyType'>Needed By: </lable>
            <input id='needByDate' name='needByDate' type='date' value="<?php echo date('Y-m-d'); ?>" onchange='dateChange()'></input>
          </td>
	  <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" style="text-align: center;">Email us for questions at: <a href="mailto:SugarShackTreat@gmail.com">SugarShackTreat@gmail.com</a></td>
        </tr>
<?php
/*
        <tr>
          <td colspan="3" style="text-align: center;"><img id='finalLogo' src="images/finalLogoSept2025.jpg"></td>
        </tr>
*/
?>
        <tr>
          <td colspan="3" style="text-align: center;">These products are homemade and not subject to state inspection.</td>
        </tr>
      </table>
      <script>
        window.onload = function() {
<?php
/*
  $headLine=0;
  foreach ($headingsArray as $id=>$value) {
    if (substr($id,-1) == "1") {
       fwrite($fp,logTime()."lastChar-".substr($id,-1)."-\n");
    }
    fwrite($fp,logTime()."id-".$id."-value-".$value."-\n");
    echo "          document.getElementById('".$id."').innerHTML = '".$value."';\n";
  }
*/
?>
          const cakeSizeObj = document.getElementById('cakeSize');	// Select
          const tableObj = document.getElementById('mainTable');
          // Loop through all cell entries
          colToDelete = 99999;
          const rows = tableObj.querySelectorAll('tr');
          rows.forEach((row, rowIndex) => {
/*
            if (row.id) {
              console.log(`  Row ${rowIndex} ID: ${row.id}`);
            } else {
              console.log(`  Row ${rowIndex}: No ID`);
            }
*/
            // Get and display cell IDs for the current row
            const cells = row.querySelectorAll('td'); // Select both data cells and header cells
            cells.forEach((cell, cellIndex) => {
              if (cell.id) {
                cellId = cell.id;
                cellText = cell.innerHTML;
                if (cellId.substring(0,6) == 'tdHead') {
                   if (cellText == '') {
//                    console.log(`Row ${rowIndex} ID: ${row.id}  Cell ${cellIndex} ID: ${cell.id} cellText |${cellText}|`);
                      colToDelete = cellIndex;
                   } // if (cellText == '')
                } // if (cellId.substring(0,6) == 'tdHead')
/*
              } else {
                console.log(`Row ${rowIndex} ID: ${row.id}  Cell ${cellIndex}: No ID`);
*/
              }
            });
          });
          // Ensure entire column is empty of data before deleteing it.
          if (colToDelete < 99999) {
             rows.forEach((row, rowIndex) => {
               const cells = row.querySelectorAll('td');                                                     cells.forEach((cell, cellIndex) => {                                                            cellText = cell.innerHTML;
                 if (cellIndex == colToDelete) {
                    if (cellText != '') {
                       colToDelete = 99999;
                    }
                 } // if (cellIndex == colToDelete)
               });
             });
          } // if (colToDelete < 99999)
          if (colToDelete < 99999) {
             // Delete all cells for colToDelete
             rows.forEach((row, rowIndex) => {
               // Get and display cell IDs for the current row
               const cells = row.querySelectorAll('td'); // Select both data cells and header cells
               cells.forEach((cell, cellIndex) => {
                 if (cellIndex == colToDelete) {
                    row.deleteCell(cellIndex);
                 } // if (cellIndex == colToDelete)
               });
             });
          } // if (colToDelete < 99999)
          // Build cakeSize select list
          cakeSizeArray = ['Choose an option', '3 inch Round', '3 inch Square', 'Loaf Pan'];
          cakePriceArray = [-1, 5, 5, 8];
          for (cake=0; cake < cakeSizeArray.length; cake++) {
            cakeItem = cakeSizeArray[cake];
            priceItem = cakePriceArray[cake];
            cakeSizeObj.options[cakeSizeObj.options.length] = new Option(cakeItem, cake);
            console.log(`  cakeItem[${cake}] [${cakeItem}] priceValue[${priceItem}]`);
          }
        } // window.onload = function()
        today = new Date();
        aYearFromNow = new Date();
        year = today.getFullYear();
        month=today.getMonth()+1;
        day=today.getDate();
        aYearFromNow.setFullYear(year + 1);
        const cakePriceObj = document.getElementById('cakePrice');	// Text
        const cakeSizeObj = document.getElementById('cakeSize');	// Select
        const cakeQtyObj = document.getElementById('cakeQty');		// Text
        const cakeQtyMsgObj = document.getElementById('cakeQtyMsg');	// Text
        const needByDateObj = document.getElementById('needByDate');	// Date
        function changeSize() {
           //
           priceAmt = 0;
           sizeIdx = cakeSizeObj.selectedIndex;
           sizeQty = cakeSizeObj[sizeIdx].value;
           cakeQty  = cakeQtyObj.value;
           priceVal = cakePriceArray[sizeIdx];
           console.log(`sizeIdx [${sizeIdx}] sizeQty (${sizeQty}) cakeQty [${cakeQty}] priceVal [${priceVal}]`);
           if (!cakeQtyObj.checkValidity()) {
               alert('Limit quanity to at least 10 and less than a 100');
               if (cakeQtyObj.value > 100) {
                  cakeQtyObj.value = 100;
                  cakeQty = 100;
               } else {
                  cakeQtyObj.value = 10;
                  cakeQty = 10;
               }
           } else {
               cakeQtyMsgObj.style.fontWeight = 'normal';
           }
           if ( (cakeQty > 0) && (sizeQty > 0) ) {
             cakePriceObj.value = '$' + (cakeQty * priceVal) + '.00';
           }
        }
        function dateChange() {
           //
           userDate = new Date(needByDateObj.value);
           console.log(`Year [${year}] Month [${month}] day [${day}]`);
           if (userDate < today) {
              console.log(`Date is too early`);
              alert('Please chooe a date after today');
              needByDateObj.value = '<?php echo date('Y-m-d'); ?>';
           } else if (userDate > aYearFromNow) {
              console.log(`Date is too late`);
              alert('Please chooe a date less than a year from now');
              needByDateObj.value = '<?php echo date('Y-m-d'); ?>';
           } else {
              console.log(`Ok`);
           }
           console.log(`User Date [${userDate}] Year [${userDate.getFullYear()}] Month [${userDate.getMonth()+1}] day [${userDate.getDate()}]`);
        }
      </script>

