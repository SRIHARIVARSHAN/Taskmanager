$(document).on('click', '.forwardedfacultyDetails', function(e) {
            e.preventDefault();

            var id = $(this).val(); // Get the id from the button value
            console.log(id);
            $.ajax({
                type: "POST",
                url: `user/forwardfetchdet/${id}`,
                success: function(response) {
                    if (response.status == 200) {
                        var forwardtaskDetails = '';

                        response.data.forEach(function(forwardtask, index) {
                            forwardtaskDetails += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${forwardtask.assigned_to_name}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    ${forwardtask.status === 9 ? 'pending' :
                                    forwardtask.status === 15 ? 'Redo' :
                                    forwardtask.status === 17 ? 'pending' :
                                    forwardtask.status === 23 ? 'Redo' : 'Unknown status'}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btnapprove" value="${forwardtask.id}" >
                                    <i class="fas fa-circle-check"></i>
                                </button>
                                <button type="button" class="btn btn-danger btnredo  " value="${forwardtask.id}">
                                    <i class="fas fa-arrows-rotate"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                        });
                        $('#forwardtaskDetails').html(forwardtaskDetails); // Dynamically populate task details in the modal
                        $('#forwardviewDetails .modal-body table tbody').html(forwardtaskDetails);
                        $('#forwardviewDetails').modal('show');
                    } else {
                        alert(response.message || 'No faculty details found.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", xhr.responseText);
                    alert('An error occurred while fetching the faculty details: ' + error);
                }
            });
        });




        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                <div class="custom-table table-responsive">
                                    <table class="table mb-0 table-hover " id="overdue1">
                                        <thead class="gradient-header">
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Task ID</th>
                                                <th class="text-center">Assigned by</th>
                                                <th class="text-center">Title</th>
                                                <th class="text-center">Task Description</th>
                                                <th class="text-center">Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $sno=1 @endphp
                                            @foreach ($overdueTasks as $over)
                                            <tr>
                                                <td class="text-center">{{$sno++}}</td>
                                                <td class="text-center">{{$over->task_id}}</td>
                                                <td class="text-center"> {{$over->assign_by_name}} </td>
                                                <td class="text-center">{{$over->title}}</td>
                                                <td class="text-center">{{$over->description}}</td>

                                                <td class="text-center">{{\Carbon\Carbon::parse($over->deadline)->format('d-m-Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                            Route::get('/tasks/overdue', [userController::class, 'getOverdueTasks'])->name('tasks.overdue');




                            $overdue_tasks = Maintask::whereIn('task_id', $my_det) // Match tasks assigned to the faculty
            ->where('deadline', '<=', $currentDate) // Deadline has passed
            ->select('task_id','title', 'description', 'assign_by_name', 'deadline') // Select required columns
            ->get();


        $overdue_sub_tasks = Subtask::whereIn('task_id', $sub) // Match tasks assigned to the faculty
            ->where('deadline', '<=', $currentDate) // Deadline has passed
            ->select('task_id', 'assigned_by_name', 'deadline') // Select required columns
            ->get();





            $overdueTasks = $overdue_tasks->merge($overdue_sub_tasks);


            // Fetch completed main tasks with completed_date
        $completedMainTasks = Maintask::where('assign_by_id', $facultyId)
        ->where('Maintask.status', '2')
            ->join('Mainbranch', 'Mainbranch.task_id', '=', 'Maintask.task_id')
            ->select('Mainbranch.task_id', 'Maintask.title', 'Maintask.assign_by_id', 'Maintask.assign_by_name', 'Maintask.description', 'Mainbranch.completed_date', 'Mainbranch.assigned_to_id')
            ->get();

        // Fetch completed subtasks with completed_date
        $completedSubtasks = Subtask::where('assigned_by_id', $facultyId)
        ->where('subtask.status', '3') 
            ->join('Maintask', 'Subtask.task_id', '=', 'Maintask.task_id')
            ->select('Maintask.task_id', 'Maintask.title', 'Maintask.assign_by_id', 'Maintask.assign_by_name', 'Maintask.description', 'Subtask.completed_date')
            ->get();

        // Merge the results
        $completed = $completedMainTasks->merge($completedSubtasks);



        ///overdue
        $overdue_sub_tasks = Subtask::whereIn('task_id', $sub) // Match tasks assigned to the faculty
            ->where('deadline', '<=', $currentDate) // Deadline has passed
            ->select('task_id', 'assigned_by_name', 'deadline') // Select required columns
            ->get();
