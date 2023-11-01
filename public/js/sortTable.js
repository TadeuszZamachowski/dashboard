function sortTable(n, isStatus, isLink, isDate, isNum) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("orders-table");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        if(isLink == 1) {
          x = rows[i].getElementsByTagName("a")[0].innerHTML;
          y = rows[i + 1].getElementsByTagName("a")[0].innerHTML;
        } else if(isStatus == 1) {
          x = rows[i].getElementsByTagName("option")[0].innerHTML;
          y = rows[i + 1].getElementsByTagName("option")[0].innerHTML;
        } else {
          x = rows[i].getElementsByTagName("TD")[n].innerHTML;
          y = rows[i + 1].getElementsByTagName("TD")[n].innerHTML;
        }
        if(isNum == 1) {
          x = parseFloat(x);
          y = parseFloat(y);
        } else if (isDate == 1) {
          arr1 = x.split("-");
          arr2 = y.split("-");
          x = arr1[2].concat("-", arr1[1], "-", arr1[0]);
          y = arr2[2].concat("-", arr2[1], "-", arr2[0]);
          x = new Date(x);
          y = new Date(y);
        } else {
          x = x.toLowerCase();
          y = y.toLowerCase();
        }
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
          if (x > y) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        } else if (dir == "desc") {
          if (x < y) {
            // If so, mark as a switch and break the loop:
            shouldSwitch = true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++;
      } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount == 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }