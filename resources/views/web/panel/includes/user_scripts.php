<script>
    async function submitFormRequest(submit = 0, uf_id, form_data) {
        // 🔍 Parse responses

        if (submit == 1) {
            const responsesRaw = form_data.get('responses');
            const responses = responsesRaw ? JSON.parse(responsesRaw) : [];


            await prepareDiagramPointerImages(form_data, responses);

        }

        const dataUrl = `<?= route('users.form-submit', ['uf_id' => '__ID__']) ?>`.replace('__ID__', uf_id);

        $.ajax({
            url: dataUrl + "?submit=" + submit,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: form_data,
            processData: false,
            contentType: false,
            success: function (response) {
                try {
                    const res = typeof response === "string" ? JSON.parse(response) : response;

                    if (res.code === "200") {
                        jsonMessage2(res.status, res.message, res.messageTitle || '');

                        if (submit === 1) {
                            localStorage.removeItem(`form_time_spent_${uf_id}`);
                            const redirect = res.data?.redirect;
                            setTimeout(() => window.location.href = redirect, 1500);
                        }
                    } else if (["300", "302"].includes(res.code)) {
                        jsonMessage2("error", res.message, res.messageTitle || "Error");
                    }
                } catch (e) {
                    console.error("Invalid JSON in response", response);
                }
            },
            error: function (xhr) {
                console.error(xhr);
                jsonMessage2("error", "Submission failed. Please try again.", "Server Error");
            }
        });
    }



    function view_reports(user_id) {
        var dataUrl = `<?= route('user.view_reports', ['user_id' => '__ID__']) ?>`.replace('__ID__', user_id);
        $.ajax({
            url: dataUrl,
            success: function (data) {
                $('#view_reports').html(data);
            }
        })
    }

    function view_draft_reports(user_id) {
        var dataUrl = `<?= route('user.form.drafts.ajax', ['user_id' => '__ID__']) ?>`.replace('__ID__', user_id);
        $.ajax({
            url: dataUrl,
            success: function (data) {
                $('#view_draft_reports').html(data);
            }
        })
    }



    // function test123(value, callback) {
    //     var user_form_id = $("#user-form-id").val();
    //     var dataUrl = "<?= route('users.form.change-name') ?>";

    //     $.ajax({
    //         url: dataUrl + "?uf_id=" + user_form_id + "&case_id=" + value,
    //         success: function (response) {
    //             if (isJSON(response)) {
    //                 const result = JSON.parse(response);
    //                 if (result['code'] === '300') {
    //                     jsonMessage(result['status'], result['message']);
    //                     callback(false); 
    //                 } else if (result['code'] === '200') {
    //                     jsonMessage2(result['status'], result['message'], result['messageTitle']);
    //                     callback(true);
    //                 }
    //             }
    //         },
    //         error: function () {
    //             jsonMessage2('error', 'Something went wrong while processing your request.');
    //             callback(false);
    //         }
    //     });
    // }

    async function promptOptionalCaseIdAndSubmit(formId, formName) {
        let caseId = null;
        let cancelB = false;
        while (true) {
            try {
                caseId = await swal({
                    title: `You have selected "${formName}" form`,
                    text: "You may enter a Case ID (optional) before proceeding.",
                    input: 'text',
                    inputPlaceholder: 'Enter Case ID (optional)',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger m-l-10',
                    confirmButtonText: 'Proceed',
                });
            } catch (err) {
                cancelB = true;

                break;
            }

            if (caseId === null || caseId === false) return;

            let trimmedId = caseId.trim();

            let existingError = document.getElementById('swal-caseid-error');
            if (existingError) existingError.remove();

            if (trimmedId === '') break;

            const isValid = await validateCaseId(trimmedId, true);
            if (isValid) {
                caseId = trimmedId;
                break;
            } else {
                const inputEl = document.querySelector('.swal2-input') || document.querySelector('.swal-input');
                const errorEl = document.createElement('div');
                errorEl.id = 'swal-caseid-error';
                errorEl.style.color = 'red';
                errorEl.style.fontSize = '0.85rem';
                errorEl.style.marginTop = '6px';
                errorEl.textContent = 'This Case ID already exists. Please enter a unique one.';
                inputEl?.insertAdjacentElement('afterend', errorEl);
            }
        }
        if (cancelB == true) {
            let existingError = document.getElementById('swal-caseid-error');
            if (existingError) existingError.remove();
            return false;
        }

        document.getElementById('case_id').value = caseId.trim();
        document.getElementById('form_id').value = formId;
        document.getElementById('formCardSubmit').submit();
    }


    function validateCaseId(value, silent = false) {
        return new Promise(resolve => {
            const user_form_id = $("#user-form-id").val();
            const dataUrl = "<?= route('users.form.change-name') ?>";

            $.ajax({
                url: dataUrl,
                data: {
                    uf_id: user_form_id,
                    case_id: value
                },
                success: function (response) {
                    if (isJSON(response)) {
                        const result = JSON.parse(response);

                        if (result.code === '200') {
                            if (!silent) {
                                jsonMessage2(result.status, result.message, result.messageTitle);
                            }
                            resolve(true);
                        } else if (result.code === '300') {
                            if (!silent) {
                                jsonMessage(result.status, result.message);
                            }
                            resolve(false);
                        } else {
                            if (!silent) {
                                jsonMessage2('error', 'Unexpected response');
                            }
                            resolve(false);
                        }
                    } else {
                        if (!silent) {
                            jsonMessage2('error', 'Invalid server response');
                        }
                        resolve(false);
                    }
                },
                error: function () {
                    if (!silent) {
                        jsonMessage2('error', 'Server error during validation');
                    }
                    resolve(false);
                }
            });
        });
    }



    $(document).on("click", "#delete-user-draft-form", async function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var data_url = `<?= route('users.form.draft.delete', ['uf_id' => '__ID__']) ?>`.replace('__ID__', id);
        try {
            let isSuccess = await deleteRecordViaAjax(data_url, '', 'GET', "You want to move it to delete!");
            if (isSuccess === true) {
                view_draft_reports("<?= session()->get('userId') ?>");
            }
        } catch (error) {
            console.error("Error deleting base:", error);
        }
    });


    class FormTimer {
        constructor(displaySelector = '#live-timer', hiddenInputSelector = '#total-time-spent', ufId = null) {
            this.displayElement = document.querySelector(displaySelector);
            this.hiddenField = document.querySelector(hiddenInputSelector);
            this.ufId = ufId;
            this.timerKey = ufId ? `form_time_spent_${ufId}` : 'form_time_spent';
            this.timerInterval = null;
            this.timeSpentInSeconds = 0;

            const inputTime = parseInt(this.hiddenField?.value || '0');
            const storedTime = parseInt(localStorage.getItem(this.timerKey) || '0');
            this.timeSpentInSeconds = Math.max(inputTime, storedTime);

            this.updateDisplay();
        }

        start() {
            if (this.timerInterval) return;

            this.timerInterval = setInterval(() => {
                this.timeSpentInSeconds++;
                this.sync();
            }, 1000);
        }

        stop() {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
            this.sync();
        }

        sync() {
            if (this.hiddenField) {
                this.hiddenField.value = this.timeSpentInSeconds;
            }

            if (this.ufId) {
                localStorage.setItem(this.timerKey, this.timeSpentInSeconds);
            }

            this.updateDisplay();
        }

        updateDisplay() {
            if (this.displayElement) {
                this.displayElement.textContent = this.formatTime(this.timeSpentInSeconds);
            }
        }

        formatTime(seconds) {
            const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const secs = String(seconds % 60).padStart(2, '0');
            return `${hrs}:${mins}:${secs}`;
        }

        getTime() {
            return this.timeSpentInSeconds;
        }

        reset() {
            this.stop();
            this.timeSpentInSeconds = 0;
            if (this.ufId) {
                localStorage.removeItem(this.timerKey);
            }
            this.sync();
        }

        clearLocal() {
            if (this.ufId) {
                localStorage.removeItem(this.timerKey);
            }
        }
    }

    function initWalkAndTurnTest(containerId, initialValue = {}) {
        const testData = {
            missed_heel_to_toe: {
                forward: [],
                return: []
            },
            stepped_off_line: {
                forward: [],
                return: []
            },
            can_not_keep_balance: false,
            starts_too_soon: false,
            ...(initialValue || {})
        };

        const root = document.getElementById(containerId);
        if (!root) return;

        const missedF = renderSteps(`${containerId}-missedForward`, 1, 9, false, testData.missed_heel_to_toe.forward);
        const missedR = renderSteps(`${containerId}-missedReturn`, 1, 9, true, testData.missed_heel_to_toe.return);
        const steppedF = renderSteps(`${containerId}-steppedForward`, 1, 9, false, testData.stepped_off_line.forward);
        const steppedR = renderSteps(`${containerId}-steppedReturn`, 1, 9, true, testData.stepped_off_line.return);

        document.getElementById(`${containerId}-balance`).checked = testData.can_not_keep_balance;
        document.getElementById(`${containerId}-startsSoon`).checked = testData.starts_too_soon;

        document.getElementById(`${containerId}-balance`).addEventListener("change", e => {
            testData.can_not_keep_balance = e.target.checked;
            updateHidden();
        });

        document.getElementById(`${containerId}-startsSoon`).addEventListener("change", e => {
            testData.starts_too_soon = e.target.checked;
            updateHidden();
        });

        function renderSteps(id, start, end, reverse = false, marked = []) {
            const el = document.getElementById(id);
            el.innerHTML = ""; // ✅ Clear previous steps if already present

            const range = reverse
                ? [...Array(end - start + 1).keys()].map(i => end - i)
                : [...Array(end - start + 1).keys()].map(i => start + i);

            const steps = [];

            range.forEach(num => {
                const div = document.createElement("div");
                div.className = "step";
                div.textContent = num;
                if (marked.includes(num)) div.classList.add("red");

                el.appendChild(div);

                div.addEventListener("click", () => {
                    div.classList.toggle("red");
                    updateHidden();
                });

                steps.push({
                    el: div,
                    number: num
                });
            });

            return steps;
        }

        function getMarked(steps) {
            return steps.filter(s => s.el.classList.contains("red")).map(s => s.number);
        }

        function updateHidden() {
            testData.missed_heel_to_toe.forward = getMarked(missedF);
            testData.missed_heel_to_toe.return = getMarked(missedR);
            testData.stepped_off_line.forward = getMarked(steppedF);
            testData.stepped_off_line.return = getMarked(steppedR);

            const missedCount = testData.missed_heel_to_toe.forward.length + testData.missed_heel_to_toe.return.length;
            const steppedCount = testData.stepped_off_line.forward.length + testData.stepped_off_line.return.length;

            document.getElementById(`${containerId}-missedCount`).textContent = missedCount;
            document.getElementById(`${containerId}-steppedCount`).textContent = steppedCount;

            // ✅ Save data to hidden input
            document.getElementById(`${containerId}-result`).value = JSON.stringify(testData);
        }

        updateHidden();
    }

    function renderBadgeRow(label, values) {
        if (!values.length) return '';
        return `
        <div class="d-flex align-items-center mb-1">
            <div style="min-width: 70px; font-size: 0.85rem; color: #444;">${label}:</div>
            <div class="d-flex flex-wrap gap-1">
                ${values.map(n => `
                    <span style="
                        background: linear-gradient(to right, #90caf9, #0e2c50);
                        color: white;
                        border-radius: 50%;
                        width: 26px;
                        height: 26px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 0.85rem;
                        font-weight: 500;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
                    ">${n}</span>`).join('')}
            </div>
        </div>
    `;
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("canvas.diagram-pointer-canvas").forEach(canvas => {
            const uniqueId = canvas.id.replace("-canvas", "");
            const ctx = canvas.getContext("2d");
            const imageSrc = canvas.dataset.image;
            const input = document.getElementById(`${uniqueId}-input`);
            let scale = 1;
            let markers = [];

            const baseImg = new Image();
            baseImg.crossOrigin = "anonymous";
            baseImg.src = imageSrc;

            baseImg.onload = () => {
                scale = Math.min(500 / baseImg.width, 500 / baseImg.height);
                canvas.width = baseImg.width * scale;
                canvas.height = baseImg.height * scale;
                redraw();
            };

            try {
                const parsed = input.value ? JSON.parse(input.value) : null;
                markers = Array.isArray(parsed) ? parsed : parsed?.pointers || [];
            } catch {
                markers = [];
            }

            function redraw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(baseImg, 0, 0, canvas.width, canvas.height);
                markers.forEach(m => {
                    ctx.save();
                    ctx.beginPath();
                    ctx.shadowBlur = 10;
                    ctx.shadowColor = "rgba(255, 0, 0, 0.3)";
                    ctx.fillStyle = "rgba(255, 0, 0, 0.45)";
                    ctx.arc(m.x, m.y, 12, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.restore();
                });
                input.value = JSON.stringify(markers);
            }

            canvas.addEventListener("click", e => {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                markers.push({ x, y });
                redraw();
            });

            document.querySelector(`#${uniqueId}-wrapper .diagram-undo`).addEventListener("click", () => {
                markers.pop();
                redraw();
            });

            document.querySelector(`#${uniqueId}-wrapper .diagram-clear`).addEventListener("click", () => {
                markers = [];
                redraw();
            });
        });
    });



    $(document).on("click", "#generate-ai-report", async function (event) {
        event.preventDefault();

        const $btn = $(this);
        const id = $btn.attr("data-id");
        const confirmUrl = `<?= route('user.report.generate-ai-report', ['uf_id' => '__ID__']) ?>`.replace('__ID__', id);
        const jobUrl = `<?= route('user.report.generate-ai-report2', ['uf_id' => '__ID__']) ?>`.replace('__ID__', id);

        try {
            let isSuccess = await deleteRecordViaAjax(confirmUrl, '', 'GET', "You sure you want to generate AI Report?");

            if (isSuccess === true) {
                $btn.replaceWith(`
                <span>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Please wait...
                </span>
            `);

                $.ajax({
                    url: jobUrl,
                    method: 'GET',
                    success: function (res) {
                        console.log("AI job dispatched:", res);
                    },
                    error: function (err) {
                        console.error("Job dispatch error:", err);
                    }
                });
            }
        } catch (error) {
            console.error("Error confirming:", error);
        }
    });




</script>