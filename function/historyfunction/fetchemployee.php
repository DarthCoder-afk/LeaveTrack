
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 15px; overflow: hidden;">
                      
            <div class="modal-header text-white" style="background: linear-gradient(135deg,rgb(21, 255, 138) 0%,rgb(45, 223, 113) 100%); border-bottom: none;">
                <h5 class="modal-title" id="travelApplicationModalLabel">👥 Employee List</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                         
                <div class="modal-body p-4" style="background: #f8f9fa;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-center border rounded" style="border-radius: 10px; overflow: hidden;" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                <th>ID No.</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include '../database/db_connect.php';
                                $result = $conn->query("SELECT * FROM employee");
                                while ($row = $result->fetch_assoc()) {
                                    $full_name = "{$row['lname']}, {$row['fname']} {$row['extname']} {$row['midname']}";
                                    echo "<tr class='text-center'>";
                                    echo "<td class='text-primary'><b>{$row['employee_id']}</b></td>";
                                    echo "<td>{$full_name}</td>";
                                    echo "<td>{$row['position']}</td>";
                                    echo "<td>{$row['office']}</td>";        
                                    echo "</tr>";
                                } 
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>                  
        </div>
    </div>
</div>




