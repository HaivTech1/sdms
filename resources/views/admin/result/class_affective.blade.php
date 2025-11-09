
<x-app-layout>
    @section('title', application('name')." | Result Affective")
    @section('styles')
        <style>
            .affective-page {
                padding: 1.5rem 0;
            }

            .affective-card {
                background: #ffffff;
                border-radius: 20px;
                box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
                border: 1px solid rgba(148, 163, 184, 0.15);
                overflow: hidden;
            }

            .affective-header {
                background: #4f46e5;
                color: #ffffff;
                padding: 2rem;
                text-align: center;
            }

            .affective-title {
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                color: #ffffff;
            }

            .affective-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin: 0;
            }

            .filter-section {
                background: #f8fafc;
                border-bottom: 1px solid #e2e8f0;
                padding: 2rem;
            }

            .filter-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                align-items: end;
            }

            .filter-field label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }

            .filter-field .form-control {
                border-radius: 12px;
                border: 1px solid rgba(148, 163, 184, 0.3);
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
                transition: all 0.2s ease;
            }

            .filter-field .form-control:focus {
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            }

            .fetch-btn {
                background: #4f46e5;
                border: none;
                border-radius: 8px;
                color: #ffffff;
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s ease;
                width: 100%;
                justify-content: center;
            }

            .fetch-btn:hover {
                background: #3730a3;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            }

            .fetch-btn i {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                padding: 4px;
                font-size: 0.875rem;
            }

            .assessment-section {
                padding: 2rem;
            }

            .assessment-table-wrapper {
                border-radius: 12px;
                overflow-x: auto;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                -webkit-overflow-scrolling: touch;
            }

            .assessment-table {
                margin: 0;
                width: 100%;
                min-width: 800px;
            }

            .assessment-table thead th {
                background: #4f46e5;
                color: #ffffff;
                font-size: 0.875rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 1rem 0.75rem;
                border: none;
                text-align: center;
            }

            .assessment-table tbody td {
                padding: 1rem 0.75rem;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
                background: #ffffff;
            }

            .assessment-table tbody tr {
                transition: background-color 0.2s ease;
            }

            .assessment-table tbody tr:nth-child(even) {
                background: #fafbfc;
            }

            .assessment-table tbody tr:hover {
                background: #f0f4ff;
            }

            .student-name-cell {
                font-weight: 600;
                color: #1e293b;
                min-width: 250px;
            }

            .domain-cell {
                text-align: center;
                min-width: 120px;
            }

            .domain-title {
                font-size: 0.75rem;
                font-weight: 600;
                color: #64748b;
                margin-bottom: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .rating-options {
                display: flex;
                justify-content: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .form-check {
                margin: 0;
            }

            .form-check-input {
                width: 18px;
                height: 18px;
                border: 2px solid #d1d5db;
                border-radius: 4px;
                transition: all 0.2s ease;
            }

            .form-check-input:checked {
                background: #10b981;
                border-color: #10b981;
            }

            .form-check-label {
                font-size: 0.75rem;
                font-weight: 600;
                color: #6b7280;
                margin-left: 0.25rem;
            }

            .alert-section {
                margin: 1.5rem 2rem 0;
                padding: 1rem 1.5rem;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 12px;
                color: #991b1b;
            }

            .alert-section p {
                margin: 0;
                font-size: 0.875rem;
            }

            .save-section {
                padding: 2rem;
                text-align: center;
                border-top: 1px solid #e2e8f0;
                background: #f8fafc;
            }

            .save-btn {
                background: #10b981;
                border: none;
                border-radius: 8px;
                color: #ffffff;
                font-weight: 600;
                padding: 0.875rem 2rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s ease;
                min-width: 140px;
                justify-content: center;
            }

            .save-btn:hover {
                background: #059669;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
            }

            @media (max-width: 768px) {
                .filter-grid {
                    grid-template-columns: 1fr;
                }

                .rating-options {
                    gap: 0.25rem;
                }

                .affective-header {
                    padding: 1.5rem;
                }

                .assessment-section,
                .filter-section,
                .save-section {
                    padding: 1rem;
                }

                .assessment-table-wrapper {
                    margin: 0 -1rem;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                }

                .assessment-table {
                    min-width: 600px;
                }

                .assessment-table thead th,
                .assessment-table tbody td {
                    padding: 0.5rem 0.4rem;
                    font-size: 0.8rem;
                }

                .student-name-cell {
                    min-width: 150px;
                }
            }

            @media (max-width: 576px) {
                .affective-header {
                    padding: 1rem;
                    text-align: center;
                }

                .affective-title {
                    font-size: 1.4rem;
                }

                .affective-subtitle {
                    font-size: 0.9rem;
                }

                .assessment-table {
                    min-width: 500px;
                }

                .assessment-table thead th,
                .assessment-table tbody td {
                    padding: 0.4rem 0.3rem;
                    font-size: 0.75rem;
                }

                .form-check-input {
                    width: 16px;
                    height: 16px;
                }

                .form-check-label {
                    font-size: 0.7rem;
                }
            }
        </style>
    @endsection

    <div class="affective-page">
        <div class="row">
            <div class="col-12">
                <div class="affective-card">
                    <div class="affective-header">
                        <h5 class="affective-title">Affective Assessment</h5>
                        <p class="affective-subtitle">Evaluate and manage student affective domain ratings</p>
                    </div>

                    <div class="filter-section">
                        <form id="fetchStudent">
                            <div class="filter-grid">
                                <div class="filter-field">
                                    <label for="grade_id">Class</label>
                                    <select class="form-control" id="grade_id" name="grade_id">
                                        <option value=''>Select Class</option>
                                        @foreach ($grades as $grade)
                                        <option value="{{  $grade->id() }}">{{ $grade->title() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="filter-field">
                                    <label for="period_id">Session</label>
                                    <select class="form-control" id="period_id" name="period_id">
                                        <option value=''>Select Session</option>
                                        @foreach ($periods as $period)
                                        <option value="{{  $period->id() }}">{{ $period->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="period_id" />
                                </div>

                                <div class="filter-field">
                                    <label for="term_id">Term</label>
                                    <select class="form-control" id="term_id" name="term_id">
                                        <option value=''>Select Term</option>
                                        @foreach ($terms as $term)
                                        <option value="{{  $term->id() }}">{{ $term->title() }}</option>
                                        @endforeach
                                    </select>
                                    <x-form.error for="term_id" />
                                </div>
                                
                                <div class="filter-field">
                                    <label>&nbsp;</label>
                                    <button type="submit" id="fetchStudentButton" class="fetch-btn">
                                        <i class="bx bx-search-alt"></i>
                                        Load Students
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="assessment-section">

                        <form id="commentForm">
                            @csrf
                            <input type="hidden" name="period_id" id="periodId" value="" />
                            <input type="hidden" name="term_id" id="termId" value="" />

                            <div class="assessment-table-wrapper">
                                <table id="affective-data" class="table assessment-table">
                                    <thead>
                                        @php
                                            $affectives = get_settings('affective_domain');
                                        @endphp
                                        <tr>
                                            <th class="text-start">Student Name</th>
                                            @foreach ($affectives as $key => $affective)
                                                <th>{{ $affective}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                            <div id="noAffectiveList" class="alert-section d-none">
                                <p><strong>Notice:</strong> The following students' affective domains have not been computed:</p>
                                <p class="listNoAffective"></p>
                            </div>
                        </form>
                    </div>

                    <div class="save-section">
                        <button type="submit" form="commentForm" id="submitComment" class="save-btn">
                            <i class="bx bx-save"></i>
                            Save Assessments
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('#fetchStudent').on('submit', function(e){
                e.preventDefault();

                var button = $('#fetchStudentButton');
                toggleAble(button, true, 'Fetching...');

                var grade = $('#grade_id').val();
                var period = $('#period_id').val();
                var term = $('#term_id').val();

                $.ajax({
                    url: '{{ route("grade.students", ["grade" => ":grade_id"]) }}'.replace(':grade_id', grade),
                    type: 'GET',
                    dataType: 'json',
                }).done((response) => {
                    var students = response.student;

                    $.ajax({
                        url: '{{ route("student.affectives", ["period" => ":period_id", "term" => ":term_id"]) }}'.replace(':period_id', period).replace(':term_id', term),
                        type: 'GET',
                        dataType: 'json',
                    }).done((res) => {
                        toggleAble(button, false);
                        var affectives = res.affectives;

                        $('#periodId').val(period);
                        $('#termId').val(term);

                        displayAffective(students, affectives);
                    }).fail((error) => {
                        toggleAble(button, false);
                        toastr.error(error.responseJSON.message);
                    });
                    
                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                });
            });

            function displayAffective(students, initialData){
                var tableRows = '';
                var listAffectives = @json(get_settings('affective_domain'));

                students.forEach(function(student) {

                    var affectivesList = '';
                    listAffectives.forEach(function(domain, index) {
                        var radioButtons = '';

                        for (var i = 1; i <= 5; i++) {
                            var psycho = initialData.find(psycho => psycho.student_id === student['id'] && psycho.title.trim() == domain.trim());
                            var isChecked = psycho && psycho.value == i ? 'checked' : '';

                            radioButtons += `
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-${student['id']}-${index + 1}-${i}-${domain}" name="affectives[${student['id']}][${domain}][]" value="${i}" ${isChecked} />
                                    <label class="form-check-label" for="checkbox-${student['id']}-${index + 1}-${i}">${i}</label>
                                </div>
                            `;
                        }
                        affectivesList += `<td>${domain}${radioButtons}</td>`;
                    });

                    tableRows += `
                        <tr>
                            <td class="text-left" style="width: 300px">
                                ${student['name']}
                                <input type="hidden" class="form-control" id="student-${student['id']}" name="students[]" value="${student['id']}" />
                            </td>
                            ${affectivesList}
                        </tr>
                    `;
                });

                $('#affective-data tbody').html(tableRows);
            }


            $('#commentForm').on('submit', function(e){
                e.preventDefault();
                var button = $('#submitComment');
                toggleAble(button, true, 'Updating...');

                var data = $(this).serializeArray();
                var url = "{{ route('result.batchAffective') }}";

                $.ajax({
                    url,
                    type: 'POST',
                    data,
                }).done((response) => {
                    toggleAble(button, false);
                    toastr.success(response.message);
                    resetForm('#commentForm');
                    var no_affective_count = response.no_affective.count;
                    var no_affective = response.no_affective.data;

                    var listRow = '';
                    if (no_affective_count > 0) {
                        no_affective.forEach(function(name, index) {
                            listRow += (index < no_affective_count - 1) ? `${name}, ` : `${name}.`;
                        });
                        $('#noAffectiveList .listNoAffective').html(listRow);
                        $('#noAffectiveList').removeClass('d-none'); 
                    } else {
                        $('#noAffectiveList').addClass('d-none');
                    }

                    setTimeout(() => {
                        $('#noAffectiveList').addClass('d-none');
                    }, 10000);

                }).fail((error) => {
                    toggleAble(button, false);
                    toastr.error(error.responseJSON.message);
                    console.log(error);
                });
            });
            
        </script>
    @endsection
</x-app-layout>