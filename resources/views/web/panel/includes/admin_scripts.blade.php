<script>
    function initializeMap(longitude, latitude, mapId) {
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            console.error('Google Maps API has not loaded.');
            return;
        }

        const mapOptions = {
            center: {
                lat: latitude,
                lng: longitude
            },
            zoom: 15,
        };

        const mapElement = document.getElementById(mapId);
        if (!mapElement) {
            console.error(`Element with ID '${mapId}' not found.`);
            return;
        }

        const map = new google.maps.Map(mapElement, mapOptions);

        new google.maps.Marker({
            position: {
                lat: latitude,
                lng: longitude
            },
            map: map,
            title: "Location",
        });
    }

    let map, marker;

    function initMap(longitude = "", latitude = "") {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                let user_longitude = parseFloat(position.coords.longitude);
                let user_latitude = parseFloat(position.coords.latitude);

                if (longitude !== "") user_longitude = parseFloat(longitude);
                if (latitude !== "") user_latitude = parseFloat(latitude);
                const userLocation = {
                    lat: user_latitude,
                    lng: user_longitude,
                };
                map = new google.maps.Map(document.getElementById("map"), {
                    center: userLocation,
                    zoom: 13,
                    mapTypeId: "roadmap",
                    mapTypeControl: false,
                    fullscreenControl: false
                });

                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: userLocation,
                    visible: true,
                });

                updateLatLngFields(userLocation.lat, userLocation.lng);

                const input = document.getElementById("pac-input");
                const searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                map.addListener("bounds_changed", () => {
                    searchBox.setBounds(map.getBounds());
                });

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();

                    if (places.length == 0) return;

                    const place = places[0];
                    if (!place.geometry || !place.geometry.location) return;

                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                    updateLatLngFields(place.geometry.location.lat(), place.geometry.location.lng());
                    document.getElementById("selected-address").innerText = place.formatted_address;
                });

                marker.addListener("dragend", (event) => {
                    updateLatLngFields(event.latLng.lat(), event.latLng.lng());
                });
            }, () => {
                handleLocationError(true, map.getCenter());
            });
        } else {
            handleLocationError(false, map.getCenter());
        }
    }

    function updateLatLngFields(lat, lng) {
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
    }

    function handleLocationError(browserHasGeolocation, pos) {
        alert(browserHasGeolocation ?
            "Error: The Geolocation service failed." :
            "Error: Your browser doesn't support geolocation.");
    }


    async function saveFormDataAjax(form_data, form_url, submit_button_text) {
        $(".print-error-msg1").hide();
        $("#custom-save-button").html('<i class="fa fa-spinner fa-spin"></i><i>please wait</i>');
        try {
            const response = await $.ajax({
                method: 'post',
                url: form_url,
                data: form_data,
                processData: false,
                contentType: false,
                async: true
            });
            if (isJSON(response)) {

                const result = JSON.parse(response);
                if (result['code'] === '302') {
                    $(".print-error-msg1").show();
                    printErrorMsg1(result['message']);
                    let $modalBody = $(".modal-body");
                    if ($modalBody.length > 0) {
                        $modalBody.animate({
                            scrollTop: $modalBody.scrollTop() + $(".print-error-msg1").position().top
                        }, 1000);
                    }
                    jsonMessage2('error', 'Required Field cannot be left empty', "Validation");
                    $("#custom-save-button").html(submit_button_text);
                    return false;
                } else if (result['code'] === '300') {
                    $("#custom-save-button").html(submit_button_text);
                    jsonMessage2(result['status'], result['message']);
                    return false;
                } else if (result['code'] === '200') {
                    $("#custom-save-button").html(submit_button_text);
                    jsonMessage2(result['status'], result['message'], result['messageTitle']);
                    $(".custom-modal .btn-close").click();

                    if (result['data'] && result['data']['reload'] === true) {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                    return true;
                }
            } else {
                throw new Error(response);
            }

        } catch (error) {
            console.log(error.message);
            $("#custom-save-button").html(submit_button_text);
            return false;
        }
    }


    async function deleteRecordViaAjax(data_url, query_parameters = "", method = 'GET', text =
        "You want to delete it, You won't be able to revert it!") {
        if (query_parameters !== "") {
            data_url = data_url + query_parameters;
        }
        const userConfirmed = await swal({
            title: 'Are You Sure?',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            confirmButtonText: 'Yes, do it!'
        }).then(result => {
            return result;
        }).catch(() => false);
        if (!userConfirmed) {
            return false;
        }
        try {
            const response = await $.ajax({
                method: method,
                url: data_url,
                async: true
            });
            if (isJSON(response)) {
                const result = JSON.parse(response);
                if (result['code'] === '300') {
                    jsonMessage(result['status'], result['message']);
                    return false;
                } else if (result['code'] === '200') {
                    jsonMessage2(result['status'], result['message'], result['messageTitle']);
                    return true;
                }
            } else {
                throw new Error(response);
            }
        } catch (error) {
            console.log(error.message);
            return false;
        }
    }

    function isJSON(str) {

        if (!isNaN(str)) return false;

        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    async function changeStatusToggle(form_url, data_to_send, method = "POST") {
        if (data_to_send instanceof FormData) {
            data_to_send.append('_token', '<?= csrf_token() ?>');
        } else {
            data_to_send._token = '<?= csrf_token() ?>';
        }
        try {
            const response = await $.ajax({
                method: method,
                url: form_url,
                processData: false,
                contentType: false,
                async: true,
                data: data_to_send,
            });
            if (isJSON(response)) {
                const result = JSON.parse(response);
                if (result['code'] === '300') {
                    jsonMessage(result['status'], result['message']);
                    return false;
                } else if (result['code'] === '200') {
                    jsonMessage2(result['status'], result['message'], result['messageTitle']);
                    return true;
                }
            } else {
                throw new Error(response);
            }
        } catch (error) {
            console.log(error.message);
            return false;
        }
    }

    $(document).ajaxComplete(function(event, xhr, settings) {
        applyToggleStatus();
        applyDataTables();
        applySelect2();
    });

    function applyToggleStatus() {
        if ($('.c-toggle-status').length) {
            $('.c-toggle-status').bootstrapToggle();
        }
    }


    if ($('.c-select2').length) {

        $(".c-select2").select2({
            closeOnSelect: false,
            placeholder: "Placeholder",
            allowHtml: true,
            allowClear: true,
            tags: true // создает новые опции на лету
        });
        // $('').select2();
    }

    function applySelect2() {
        if ($('.c-select2').length && !$('.c-select2').data('select2')) {
            $(".c-select2").select2({
                dropdownParent: $(".custom-modal")
            });
        }
    }

    function applyDataTables() {
        if ($('#datatable-buttons').length && !$.fn.DataTable.isDataTable('#datatable-buttons')) {
            $('#datatable-buttons').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        text: 'Export to excel',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export to pdf',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }
                ]
            });
        }
    }

    async function updateSpecificfield(form_url, method = "GET") {
        try {
            const response = await $.ajax({
                method: method,
                url: form_url,
                async: true
            });
            if (isJSON(response)) {
                const result = JSON.parse(response);
                if (result['code'] === '300') {
                    jsonMessage(result['status'], result['message']);
                    return false;
                } else if (result['code'] === '200') {
                    jsonMessage2(result['status'], result['message'], result['messageTitle']);
                    return true;
                }
            } else {
                throw new Error(response);
            }
        } catch (error) {
            console.log(error.message);
            return false;
        }
    }


    function toggleTheme(mode) {
        fetch(`/toggle-theme/${mode}`)
            .then(() => location.reload());
    }


    function changeTheme(color) {
        fetch(`/set-theme-color/${color}`)
            .then(() => {
                document.documentElement.setAttribute('data-theme-mode', color);
            });
    }

    document.documentElement.setAttribute(
        'data-theme-mode',
        '{{ session('theme_color', 'default') }}'
    );


    function updateProgressBar() {
        const totalSections = document.querySelectorAll('fieldset.section-field').length;
        const currentSectionIndex = Array.from(document.querySelectorAll('fieldset.section-field')).findIndex(
            fieldset => fieldset.style.display === 'block');
        const progress = ((currentSectionIndex + 1) / totalSections) * 100;
        const progressBar = document.getElementById('formProgressBar');
        if (progressBar) {
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
        }
    }

    // function collectPreviewData() {
    //     const previewArea = document.getElementById('previewArea');
    //     previewArea.innerHTML = '';

    //     document.querySelectorAll('.section-field').forEach((section, sectionIndex) => {
    //         const sectionTitle = section.querySelector('h3')?.textContent || `Section ${sectionIndex + 1}`;
    //         const sectionDescription = section.querySelector('p')?.textContent || '';
    //         const sectionPreviewItems = [];
    //         let questionCounter = 1;

    //         const allGroups = Array.from(section.querySelectorAll('.formgroup'));

    //         const mainGroups = allGroups.filter(group => {
    //             const input = group.querySelector('input[type="hidden"], input, select, textarea');
    //             return input && (!input.dataset.sub || input.dataset.sub === "0");
    //         });

    //         const getValue = (input, group) => {
    //             if (!input) return '';

    //             const isWalkTest = group.querySelector('.walk-and-turn-test') !== null;

    //             if (isWalkTest) {
    //                 const hiddenInput = group.querySelector('input[type="hidden"]');
    //                 if (hiddenInput && hiddenInput.value) {
    //                     try {
    //                         const data = JSON.parse(hiddenInput.value);

    //                         const canBalance = data.can_not_keep_balance ? 'Yes' : 'No';
    //                         const startsSoon = data.starts_too_soon ? 'Yes' : 'No';

    //                         const missedF = data.missed_heel_to_toe?.forward || [];
    //                         const missedR = data.missed_heel_to_toe?.return || [];
    //                         const steppedF = data.stepped_off_line?.forward || [];
    //                         const steppedR = data.stepped_off_line?.return || [];

    //                         const renderBadgeRow = (label, numbers) => {
    //                             if (!numbers.length) return '';
    //                             const badges = numbers.map(num => `
    //                 <span style="
    //                     background: linear-gradient(to bottom, #0e2c50, #90caf9);
    //                     color: white;
    //                     border-radius: 50%;
    //                     width: 26px;
    //                     height: 26px;
    //                     display: inline-flex;
    //                     align-items: center;
    //                     justify-content: center;
    //                     font-size: 0.85rem;
    //                     font-weight: 600;
    //                     margin-right: 5px;
    //                     margin-top: 5px;
    //                     box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    //                     border: 1px solid #fff;
    //                 ">${num}</span>`).join('');
    //                             return `<div class="d-flex align-items-center" style="margin-top:4px;">
    //                         <div style="min-width: 60px; font-size: 0.85rem; color:#6c757d">${label}:</div>
    //                         <div class="d-flex flex-wrap" style="gap: 4px;">${badges}</div>
    //                     </div>`;
    //                         };

    //                         const missedBlock = (missedF.length || missedR.length) ? `
    //             <div style="flex:1; min-width:220px;">
    //                 <div class="fw-semibold mb-1">Missed Heel–To–Toe:</div>
    //                 ${renderBadgeRow('Forward', missedF)}
    //                 ${renderBadgeRow('Return', missedR)}
    //             </div>
    //         ` : '';

    //                         const steppedBlock = (steppedF.length || steppedR.length) ? `
    //             <div style="flex:1; min-width:220px;">
    //                 <div class="fw-semibold mb-1">Stepped Off Line:</div>
    //                 ${renderBadgeRow('Forward', steppedF)}
    //                 ${renderBadgeRow('Return', steppedR)}
    //             </div>
    //         ` : '';

    //                         return `
    //             <div class="border rounded px-3 py-2" style="background:#fff; border-left: 5px solid; border-image: linear-gradient(to right, #90caf9, #0e2c50 99%) 1;">
    //                 <div class="mb-2 fw-bold text-primary" style="font-size: 1.05rem;">
    //                     🚶‍♂️ Walk & Turn Test Summary
    //                 </div>
    //                 <div class="mb-3">
    //                     <div><strong>Can Not Keep Balance:</strong> <span class="text-success">${canBalance}</span></div>
    //                     <div><strong>Started Too Soon:</strong> <span class="text-success">${startsSoon}</span></div>
    //                 </div>
    //                 <div class="d-flex flex-wrap gap-4">
    //                     ${missedBlock}
    //                     ${steppedBlock}
    //                 </div>
    //             </div>
    //         `;
    //                     } catch (e) {
    //                         return '<span class="text-danger">[Invalid Walk & Turn data]</span>';
    //                     }
    //                 } else {
    //                     return '<span class="text-muted">[No Walk Test data]</span>';
    //                 }
    //             }

    //             // ✅ Signature
    //             if (input.type === 'hidden' && group.querySelector('.signature-container')) {
    //                 return input.value ?
    //                     `<div class="text-muted">
    //                         <small>Signature captured:</small><br>
    //                         <img src="${input.value}" alt="Signature" style="max-height:100px; border:1px solid #ccc; padding:2px; background:#f9f9f9;">
    //                    </div>` :
    //                     '<span class="text-muted">[No Signature]</span>';
    //             }

    //             // ✅ Regular inputs
    //             if (['text', 'datetime-local', 'date', 'number'].includes(input.type)) {
    //                 return input.value.trim();

    //             } else if (input.type === 'file') {
    //                 const newFile = input.files[0];
    //                 if (newFile) return newFile.name;

    //                 const uploadedTag = group.querySelector('p.text-success a');
    //                 return uploadedTag ? uploadedTag.textContent.trim() : '';

    //             } else if (input.type === 'radio') {
    //                 const checked = group.querySelector('input[type="radio"]:checked');
    //                 return checked ? checked.value : '';

    //             } else if (input.tagName === 'SELECT') {
    //                 return Array.from(input.selectedOptions).map(opt => opt.value).filter(Boolean).join(
    //                     ', ');

    //             } else if (input.type === 'checkbox') {
    //                 return Array.from(group.querySelectorAll('input[type="checkbox"]:checked'))
    //                     .map(chk => chk.value).join(', ');
    //             }

    //             return '';
    //         };

    //         const getActiveOptionIds = (group) => {
    //             const checkedRadio = group.querySelector('input[type="radio"]:checked');
    //             if (checkedRadio) {
    //                 return [checkedRadio.getAttribute('data-option-id')];
    //             }
    //             const select = group.querySelector('select');
    //             if (select) {
    //                 return Array.from(select.selectedOptions).map(opt => opt.getAttribute('data-option-id'))
    //                     .filter(Boolean);
    //             }
    //             return [];
    //         };

    //         const renderSubAnswers = (parentId, level, parentGroup) => {
    //             const activeOptionIds = getActiveOptionIds(parentGroup);
    //             if (activeOptionIds.length === 0) return '';

    //             const children = allGroups.filter(group => {
    //                 const input = group.querySelector(
    //                     'input[type="hidden"], input, select, textarea');
    //                 return input?.dataset.sub === String(level) && input.dataset
    //                     .parentQuestionId === parentId;
    //             });

    //             const validChildren = children.filter(group => {
    //                 const optIdMatch = group.closest('.sub-question-group')?.className?.match(
    //                     /sub-question-(\d+)/);
    //                 const optionId = optIdMatch ? optIdMatch[1] : null;
    //                 return optionId && activeOptionIds.includes(optionId);
    //             });

    //             return validChildren.map(group => {
    //                 const label = group.querySelector('label')?.textContent?.trim();
    //                 const input = group.querySelector(
    //                     'input[type="hidden"], input, select, textarea');
    //                 const value = getValue(input, group);
    //                 const subId = input?.name?.replace('question_', '');

    //                 if (!label || !value) return '';

    //                 const nested = renderSubAnswers(subId, level + 1, group);
    //                 return `
    //                 <li class="mb-2">
    //                     <strong>${label}</strong><br>
    //                     <span>Response: ${value}</span>
    //                     ${nested ? `<ul class="ps-4" style="list-style-type: disc;">${nested}</ul>` : ''}
    //                 </li>
    //             `;
    //             }).join('');
    //         };

    //         mainGroups.forEach(mainGroup => {
    //             const label = mainGroup.querySelector('label')?.textContent?.trim();
    //             const input = mainGroup.querySelector('input[type="hidden"], input, select, textarea');
    //             const questionId = input?.name?.replace('question_', '');
    //             const valueText = getValue(input, mainGroup);

    //             if (!valueText || !label) return;

    //             let html = `
    //             <div class="mb-2">
    //                 <strong>${questionCounter}. ${label}</strong><br>
    //                 <span>Response: ${valueText}</span>
    //         `;

    //             const subItems = renderSubAnswers(questionId, 1, mainGroup);
    //             if (subItems) {
    //                 html += `<ul class="ps-4" style="list-style-type: disc;">${subItems}</ul>`;
    //             }

    //             html += '</div>';
    //             sectionPreviewItems.push(html);
    //             questionCounter++;
    //         });

    //         if (sectionPreviewItems.length > 0) {
    //             previewArea.innerHTML += `
    //             <div class="mb-4">
    //                 <h5 class="mb-1 text-primary">${sectionTitle}</h5>
    //                 <p class="text-muted mb-2">${sectionDescription}</p>
    //                 ${sectionPreviewItems.join('')}
    //                 <hr>
    //             </div>
    //         `;
    //         }
    //     });

    //     document.querySelector('.msForm')?.scrollIntoView({
    //         behavior: 'smooth'
    //     });

    //     const previewHTML = previewArea.innerHTML.trim();
    //     document.getElementById("submit-button").style.display = previewHTML ? "block" : "none";
    // }


    function collectPreviewData() {
        const previewArea = document.getElementById('previewArea');
        previewArea.innerHTML = '';

        document.querySelectorAll('.section-field').forEach((section, sectionIndex) => {
            const sectionTitle = section.querySelector('h3')?.textContent || `Section ${sectionIndex + 1}`;
            const sectionDescription = section.querySelector('p')?.textContent || '';
            const sectionPreviewItems = [];
            let questionCounter = 1;

            const allGroups = Array.from(section.querySelectorAll('.formgroup'));

            const mainGroups = allGroups.filter(group => {
                const input = group.querySelector('input[type="hidden"], input, select, textarea');
                return input && (!input.dataset.sub || input.dataset.sub === "0");
            });

            const getValue = (input, group) => {
                if (!input) return '';

                const isWalkTest = group.querySelector('.walk-and-turn-test') !== null;

                if (isWalkTest) {
                    const hiddenInput = group.querySelector('input[type="hidden"]');
                    if (hiddenInput && hiddenInput.value) {
                        try {
                            const data = JSON.parse(hiddenInput.value);

                            const canBalance = data.can_not_keep_balance ? 'Yes' : 'No';
                            const startsSoon = data.starts_too_soon ? 'Yes' : 'No';

                            const missedF = data.missed_heel_to_toe?.forward || [];
                            const missedR = data.missed_heel_to_toe?.return || [];
                            const steppedF = data.stepped_off_line?.forward || [];
                            const steppedR = data.stepped_off_line?.return || [];

                            const renderBadgeRow = (label, numbers) => {
                                if (!numbers.length) return '';
                                const badges = numbers.map(num => `
                    <span style="
                        background: linear-gradient(to bottom, #0e2c50, #90caf9);
                        color: white;
                        border-radius: 50%;
                        width: 26px;
                        height: 26px;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 0.85rem;
                        font-weight: 600;
                        margin-right: 5px;
                        margin-top: 5px;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                        border: 1px solid #fff;
                    ">${num}</span>`).join('');
                                return `<div class="d-flex align-items-center" style="margin-top:4px;">
                            <div style="min-width: 60px; font-size: 0.85rem; color:#6c757d">${label}:</div>
                            <div class="d-flex flex-wrap" style="gap: 4px;">${badges}</div>
                        </div>`;
                            };

                            const missedBlock = (missedF.length || missedR.length) ? `
                <div style="flex:1; min-width:220px;">
                    <div class="fw-semibold mb-1">Missed Heel–To–Toe:</div>
                    ${renderBadgeRow('Forward', missedF)}
                    ${renderBadgeRow('Return', missedR)}
                </div>
            ` : '';

                            const steppedBlock = (steppedF.length || steppedR.length) ? `
                <div style="flex:1; min-width:220px;">
                    <div class="fw-semibold mb-1">Stepped Off Line:</div>
                    ${renderBadgeRow('Forward', steppedF)}
                    ${renderBadgeRow('Return', steppedR)}
                </div>
            ` : '';

                            return `
                <div class="border rounded px-3 py-2" style="background:#fff; border-left: 5px solid; border-image: linear-gradient(to right, #90caf9, #0e2c50 99%) 1;">
                    <div class="mb-2 fw-bold text-primary" style="font-size: 1.05rem;">
                        🚶‍♂️ Walk & Turn Test Summary
                    </div>
                    <div class="mb-3">
                        <div><strong>Can Not Keep Balance:</strong> <span class="text-success">${canBalance}</span></div>
                        <div><strong>Started Too Soon:</strong> <span class="text-success">${startsSoon}</span></div>
                    </div>
                    <div class="d-flex flex-wrap gap-4">
                        ${missedBlock}
                        ${steppedBlock}
                    </div>
                </div>
            `;
                        } catch (e) {
                            return '<span class="text-danger">[Invalid Walk & Turn data]</span>';
                        }
                    } else {
                        return '<span class="text-muted">[No Walk Test data]</span>';
                    }
                }

                if (input.type === 'hidden' && group.querySelector('.signature-container')) {
                    return input.value ?
                        `<div class="text-muted">
                        <small>Signature captured:</small><br>
                        <img src="${input.value}" alt="Signature" style="max-height:100px; border:1px solid #ccc; padding:2px; background:#f9f9f9;">
                   </div>` :
                        '<span class="text-muted">[No Signature]</span>';
                }

                if (input.type === 'hidden' && group.querySelector('.diagram-pointer-wrapper')) {
                    const canvas = group.querySelector('canvas.diagram-pointer-canvas');
                    const imageSrc = canvas?.dataset.image;
                    let markers = [];

                    try {
                        markers = input.value ? JSON.parse(input.value) : [];
                    } catch {
                        return '<span class="text-danger">[Invalid marker data]</span>';
                    }

                    if (!canvas || !imageSrc || !canvas.width || !canvas.height) {
                        return '<span class="text-muted">[No image found]</span>';
                    }

                    const previewWidth = canvas.width;
                    const previewHeight = canvas.height;

                    const markerDots = markers.map(m => `
                    <div style="
                        position: absolute;
                        top: ${m.y}px;
                        left: ${m.x}px;
                        width: 24px;
                        height: 24px;
                        background: rgba(255, 0, 0, 0.6);
                        border-radius: 50%;
                        box-shadow: 0 0 6px rgba(0,0,0,0.3);
                        transform: translate(-50%, -50%);
                    "></div>
                `).join('');

                    return `
                    <div style="position: relative; display: inline-block; border: 1px solid #ccc; width: ${previewWidth}px; height: ${previewHeight}px;">
                        <img src="${imageSrc}" style="width: ${previewWidth}px; height: ${previewHeight}px; display: block;" />
                        <div style="position: absolute; top: 0; left: 0; width: ${previewWidth}px; height: ${previewHeight}px;">
                            ${markerDots}
                        </div>
                    </div>`;
                }




                if (['text', 'datetime-local', 'date', 'number'].includes(input.type)) {
                    return input.value.trim();
                } else if (input.type === 'file') {
                    const newFile = input.files[0];
                    if (newFile) return newFile.name;

                    const uploadedTag = group.querySelector('p.text-success a');
                    return uploadedTag ? uploadedTag.textContent.trim() : '';
                } else if (input.type === 'radio') {
                    const checked = group.querySelector('input[type="radio"]:checked');
                    return checked ? checked.value : '';
                } else if (input.tagName === 'SELECT') {
                    return Array.from(input.selectedOptions).map(opt => opt.value).filter(Boolean).join(
                        ', ');
                } else if (input.type === 'checkbox') {
                    return Array.from(group.querySelectorAll('input[type="checkbox"]:checked'))
                        .map(chk => chk.value).join(', ');
                }

                return '';
            };

            const getActiveOptionIds = (group) => {
                const checkedRadio = group.querySelector('input[type="radio"]:checked');
                if (checkedRadio) {
                    return [checkedRadio.getAttribute('data-option-id')];
                }
                const select = group.querySelector('select');
                if (select) {
                    return Array.from(select.selectedOptions).map(opt => opt.getAttribute('data-option-id'))
                        .filter(Boolean);
                }
                return [];
            };

            const renderSubAnswers = (parentId, level, parentGroup) => {
                const activeOptionIds = getActiveOptionIds(parentGroup);
                if (activeOptionIds.length === 0) return '';

                const children = allGroups.filter(group => {
                    const input = group.querySelector(
                        'input[type="hidden"], input, select, textarea');
                    return input?.dataset.sub === String(level) && input.dataset
                        .parentQuestionId === parentId;
                });

                const validChildren = children.filter(group => {
                    const optIdMatch = group.closest('.sub-question-group')?.className?.match(
                        /sub-question-(\d+)/);
                    const optionId = optIdMatch ? optIdMatch[1] : null;
                    return optionId && activeOptionIds.includes(optionId);
                });

                return validChildren.map(group => {
                    const label = group.querySelector('label')?.textContent?.trim();
                    const input = group.querySelector(
                        'input[type="hidden"], input, select, textarea');
                    const value = getValue(input, group);
                    const subId = input?.name?.replace('question_', '');

                    if (!label || !value) return '';

                    const nested = renderSubAnswers(subId, level + 1, group);
                    return `
                    <li class="mb-2">
                        <strong>${label}</strong><br>
                        <span>Response: ${value}</span>
                        ${nested ? `<ul class="ps-4" style="list-style-type: disc;">${nested}</ul>` : ''}
                    </li>
                `;
                }).join('');
            };

            mainGroups.forEach(mainGroup => {
                const label = mainGroup.querySelector('label')?.textContent?.trim();
                const input = mainGroup.querySelector('input[type="hidden"], input, select, textarea');
                const questionId = input?.name?.replace('question_', '');
                const valueText = getValue(input, mainGroup);

                if (!valueText || !label) return;

                let html = `
                <div class="mb-2">
                    <strong>${questionCounter}. ${label}</strong><br>
                    <span>Response: ${valueText}</span>
            `;

                const subItems = renderSubAnswers(questionId, 1, mainGroup);
                if (subItems) {
                    html += `<ul class="ps-4" style="list-style-type: disc;">${subItems}</ul>`;
                }

                html += '</div>';
                sectionPreviewItems.push(html);
                questionCounter++;
            });

            if (sectionPreviewItems.length > 0) {
                previewArea.innerHTML += `
                <div class="mb-4">
                    <h5 class="mb-1 text-primary">${sectionTitle}</h5>
                    <p class="text-muted mb-2">${sectionDescription}</p>
                    ${sectionPreviewItems.join('')}
                    <hr>
                </div>
            `;
            }
        });

        document.querySelector('.msForm')?.scrollIntoView({
            behavior: 'smooth'
        });

        const previewHTML = previewArea.innerHTML.trim();
        document.getElementById("submit-button").style.display = previewHTML ? "block" : "none";
    }

    function handleSubQuestions(input) {
        if (!input) return;

        const group = input.closest('.formgroup');
        if (!group) return;

        group.querySelectorAll('.sub-question-group').forEach(div => div.style.display = 'none');

        let selectedOptions = [];

        if (input.type === 'radio') {
            if (input.checked) {
                selectedOptions.push(input);
            }
        } else if (input.tagName === 'SELECT') {
            selectedOptions = Array.from(input.selectedOptions).filter(opt => opt.selected);
        }

        selectedOptions.forEach(option => {
            const optionId = option.getAttribute('data-option-id') || option.id.split('_')[1];
            const sub = group.querySelector(`.sub-question-${optionId}`);
            if (sub) sub.style.display = 'block';
        });
    }


    // function captureFormStateAndFiles() {
    //     const formDataArray = [];
    //     const formData = new FormData();
    //     const allGroups = document.querySelectorAll('.formgroup');

    //     allGroups.forEach(group => {
    //         if (group.closest('.sub-question-group') && group.closest('.sub-question-group').style.display ===
    //             'none') {
    //             return;
    //         }

    //         const label = group.querySelector('label')?.textContent?.trim();
    //         const input = group.querySelector('input, select, textarea');
    //         if (!input || !label) return;

    //         let rawName = input.name || '';
    //         let questionId = rawName.replace(/^question_/, '').replace(/\[\]$/, '');
    //         const parentQuestionId = input.dataset.parentQuestionId || null;
    //         const subLevel = input.dataset.sub || '0';
    //         const questionType = group.dataset.questionType || '';
    //         let optionId = null;
    //         let optionText = '';
    //         let isMultiple = input.hasAttribute('multiple');

    //         if (['text', 'datetime-local', 'date', 'number'].includes(input.type)) {
    //             optionText = input.value.trim();
    //         } else if (input.type === 'file') {
    //             if (input.files.length > 0) {
    //                 const file = input.files[0];
    //                 optionText = file.name;
    //                 formData.append(`file_question_${questionId}`, file);
    //             }
    //         } else if (input.type === 'radio') {
    //             const checked = group.querySelector('input[type="radio"]:checked');
    //             if (checked) {
    //                 optionText = checked.value;
    //                 optionId = checked.dataset.optionId || null;
    //             }
    //         } else if (input.tagName === 'SELECT') {
    //             const selected = Array.from(input.selectedOptions).filter(opt => opt.value);
    //             optionText = selected.map(opt => opt.value).join(', ');
    //             optionId = selected.map(opt => opt.getAttribute('data-option-id') || '').filter(Boolean).join(
    //                 ',');
    //         } else if (input.type === 'checkbox') {
    //             const checked = Array.from(group.querySelectorAll('input[type="checkbox"]:checked'));
    //             optionText = checked.map(chk => chk.value).join(', ');
    //             optionId = checked.map(chk => chk.dataset.optionId || '').filter(Boolean).join(',');
    //         } else if (input.type === 'hidden' && group.querySelector('.signature-container')) {
    //             if (input.value) {
    //                 optionText = input.value;
    //             }
    //         }

    //         if (optionText) {
    //             formDataArray.push({
    //                 question_id: questionId,
    //                 question_text: label,
    //                 parent_question_id: parentQuestionId,
    //                 selected_option_id: optionId,
    //                 selected_option_text: optionText,
    //                 sub_level: subLevel,
    //                 question_type: questionType
    //             });
    //         }
    //     });

    //     formData.append('responses', JSON.stringify(formDataArray));

    //     const totalTime = typeof formTimer !== 'undefined' ? formTimer.getTime() : 0;
    //     formData.append('total_time_spent', totalTime);

    //     return formData;
    // }


    // function captureFormStateAndFiles() {
    //     const formDataArray = [];
    //     const formData = new FormData();
    //     const allGroups = document.querySelectorAll('.formgroup');

    //     allGroups.forEach(group => {
    //         if (
    //             group.closest('.sub-question-group') &&
    //             group.closest('.sub-question-group').style.display === 'none'
    //         ) {
    //             return;
    //         }

    //         const label = group.querySelector('label')?.textContent?.trim();
    //         const input = group.querySelector('input[name], select[name], textarea[name]');
    //         if (!input || !label) return;

    //         let rawName = input.name || '';
    //         let questionId = rawName.replace(/^question_/, '').replace(/\[\]$/, '');
    //         const parentQuestionId = input.dataset.parentQuestionId || null;
    //         const subLevel = input.dataset.sub || '0';
    //         const questionType = group.dataset.questionType || '';
    //         let optionId = null;
    //         let optionText = '';
    //         let isMultiple = input.hasAttribute('multiple');

    //         if (['text', 'datetime-local', 'date', 'number'].includes(input.type)) {
    //             optionText = input.value.trim();

    //         } else if (input.type === 'file') {
    //             if (input.files.length > 0) {
    //                 const file = input.files[0];
    //                 optionText = file.name;
    //                 formData.append(`file_question_${questionId}`, file);
    //             }

    //         } else if (input.type === 'radio') {
    //             const checked = group.querySelector('input[type="radio"]:checked');
    //             if (checked) {
    //                 optionText = checked.value;
    //                 optionId = checked.dataset.optionId || null;
    //             }

    //         } else if (input.tagName === 'SELECT') {
    //             const selected = Array.from(input.selectedOptions).filter(opt => opt.value);
    //             optionText = selected.map(opt => opt.value).join(', ');
    //             optionId = selected.map(opt => opt.getAttribute('data-option-id') || '').filter(Boolean).join(
    //                 ',');

    //         } else if (input.type === 'checkbox') {
    //             // 🚫 Skip walk-and-turn checkboxes (handled in hidden field)
    //             if (input.classList.contains('walk-and-turn-test')) return;

    //             const checked = Array.from(group.querySelectorAll('input[type="checkbox"]:checked'));
    //             optionText = checked.map(chk => chk.value).join(', ');
    //             optionId = checked.map(chk => chk.dataset.optionId || '').filter(Boolean).join(',');

    //         } else if (input.type === 'hidden') {
    //             if (group.querySelector('.signature-container')) {
    //                 // Signature input
    //                 optionText = input.value;
    //             } else if (group.querySelector('.walk-and-turn-test')) {
    //                 // ✅ Walk-and-turn test input
    //                 optionText = input.value; // full JSON string (e.g. {"missed_heel_to_toe":...})
    //             }
    //         }

    //         if (optionText) {
    //             formDataArray.push({
    //                 question_id: questionId,
    //                 question_text: label,
    //                 parent_question_id: parentQuestionId,
    //                 selected_option_id: optionId,
    //                 selected_option_text: optionText,
    //                 sub_level: subLevel,
    //                 question_type: questionType
    //             });
    //         }
    //     });

    //     formData.append('responses', JSON.stringify(formDataArray));

    //     const totalTime = typeof formTimer !== 'undefined' ? formTimer.getTime() : 0;
    //     formData.append('total_time_spent', totalTime);

    //     return formData;
    // }



    function captureFormStateAndFiles() {
        const formDataArray = [];
        const formData = new FormData();
        const allGroups = document.querySelectorAll('.formgroup');

        allGroups.forEach(group => {
            if (
                group.closest('.sub-question-group') &&
                group.closest('.sub-question-group').style.display === 'none'
            ) {
                return;
            }

            const label = group.querySelector('label')?.textContent?.trim();
            const input = group.querySelector('input[name], select[name], textarea[name]');
            if (!input || !label) return;

            let rawName = input.name || '';
            let questionId = rawName.replace(/^question_/, '').replace(/\[\]$/, '');
            const parentQuestionId = input.dataset.parentQuestionId || null;
            const subLevel = input.dataset.sub || '0';
            const questionType = group.dataset.questionType || '';
            let optionId = null;
            let optionText = '';
            let isMultiple = input.hasAttribute('multiple');

            if (['text', 'datetime-local', 'date', 'number'].includes(input.type)) {
                optionText = input.value.trim();

            } else if (input.type === 'file') {
                if (input.files.length > 0) {
                    const file = input.files[0];
                    optionText = file.name;
                    formData.append(`file_question_${questionId}`, file);
                }

            } else if (input.type === 'radio') {
                const checked = group.querySelector('input[type="radio"]:checked');
                if (checked) {
                    optionText = checked.value;
                    optionId = checked.dataset.optionId || null;
                }

            } else if (input.tagName === 'SELECT') {
                const selected = Array.from(input.selectedOptions).filter(opt => opt.value);
                optionText = selected.map(opt => opt.value).join(', ');
                optionId = selected.map(opt => opt.getAttribute('data-option-id') || '').filter(Boolean).join(
                    ',');

            } else if (input.type === 'checkbox') {
                if (input.classList.contains('walk-and-turn-test')) return;

                const checked = Array.from(group.querySelectorAll('input[type="checkbox"]:checked'));
                optionText = checked.map(chk => chk.value).join(', ');
                optionId = checked.map(chk => chk.dataset.optionId || '').filter(Boolean).join(',');

            } else if (input.type === 'hidden') {
                if (group.querySelector('.signature-container')) {
                    optionText = input.value;

                } else if (group.querySelector('.walk-and-turn-test')) {
                    optionText = input.value;

                } else if (group.querySelector('.diagram-pointer-wrapper')) {
                    try {
                        const canvas = group.querySelector('canvas.diagram-pointer-canvas');
                        const image = canvas?.dataset.image || null;
                        const markers = input.value ? JSON.parse(input.value) : [];

                        optionText = JSON.stringify({
                            image,
                            pointers: markers
                        });
                    } catch (e) {
                        console.warn('Invalid diagram pointer data');
                        optionText = '';
                    }
                }
            }

            if (optionText) {
                formDataArray.push({
                    question_id: questionId,
                    question_text: label,
                    parent_question_id: parentQuestionId,
                    selected_option_id: optionId,
                    selected_option_text: optionText,
                    sub_level: subLevel,
                    question_type: questionType
                });
            }
        });

        formData.append('responses', JSON.stringify(formDataArray));

        const totalTime = typeof formTimer !== 'undefined' ? formTimer.getTime() : 0;
        formData.append('total_time_spent', totalTime);

        return formData;
    }

    function load_pie_chart(drafts, submitted, total, canvasId) {


        document.getElementById(`${canvasId}-drafts`).textContent = drafts;
        document.getElementById(`${canvasId}-submitted`).textContent = submitted;
        document.getElementById(`${canvasId}-total`).textContent = total;

        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');

        const gradient = ctx.createLinearGradient(350, 432, canvas.width, 0);
        gradient.addColorStop(0, "#0e2c50");
        gradient.addColorStop(1, "#90caf9");

        const pieChartData = {
            labels: ["Total Drafts", "Total Submitted"],
            datasets: [{
                data: [drafts, submitted],
                backgroundColor: [
                    "rgba(235, 239, 242, 1)",
                    gradient
                ],
                hoverBorderColor: "#fff"
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: pieChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    function update_submission_progress(totalDrafts, totalSubmitted, totalReports) {
        const submitted = totalSubmitted || 0;
        const total = totalReports || 0;

        const progressPercent = (total > 0) ? (submitted / total) * 100 : 0;

        const progressBar = document.getElementById('submissionProgress');
        if (progressBar) {
            progressBar.style.width = progressPercent + '%';
            progressBar.setAttribute('aria-valuenow', progressPercent.toFixed(0));
        }
        const submittedCountSpan = document.querySelector('.submission-count-submitted');
        const totalCountSpan = document.querySelector('.submission-count-total');
        if (submittedCountSpan && totalCountSpan) {
            submittedCountSpan.textContent = total > 0 ? submitted : '-';
            totalCountSpan.textContent = total > 0 ? ` / ${total}` : ' / -';
        }
    }


    function generate_bar_chart(dataObj, elementId) {
        const container = document.getElementById(elementId);
        if (!container) {
            console.error("Container not found:", elementId);
            return;
        }

        container.innerHTML = "";

        const labels = Object.keys(dataObj);
        const values = Object.values(dataObj);
        const total = values.reduce((sum, val) => sum + val, 0);

        const summaryRow = document.createElement("div");
        summaryRow.className = "row bar-info-show text-center mb-4";

        labels.forEach((label, index) => {
            const col = document.createElement("div");
            col.className = "col-4";
            col.innerHTML = `
            <h5 class="mb-0 font-size-18">${values[index]}</h5>
            <p class="text-muted text-truncate">${label}</p>
        `;
            summaryRow.appendChild(col);
        });

        const totalRow = document.createElement("div");
        totalRow.className = "col-12 text-center mt-2";
        totalRow.innerHTML = `<h5 class="mb-0 font-size-18 text-primary">Total: ${total}</h5>`;
        summaryRow.appendChild(totalRow);

        const canvas = document.createElement("canvas");
        canvas.height = 300;
        canvas.id = `${elementId}-chart`;
        canvas.setAttribute("data-colors", '["--bs-info"]');

        container.appendChild(summaryRow);
        container.appendChild(canvas);
        const ctx = canvas.getContext("2d");
        const gradient = ctx.createLinearGradient(0, canvas.height, 0, 0);
        gradient.addColorStop(0, "#0e2c50");
        gradient.addColorStop(1, "#90caf9");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Report Completion Analytics",
                    data: values,
                    backgroundColor: gradient,
                    borderColor: "#0e2c50",
                    borderWidth: 1,
                    hoverBackgroundColor: gradient,
                    hoverBorderColor: "#0e2c50"
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // 👈 This ensures it only shows whole numbers
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });
    }



    window.addEventListener('DOMContentLoaded', function() {
        var appStyle = document.getElementById('app-style');
        if (appStyle && appStyle.href.includes('app-dark.min.css')) {
            document.body.style.backgroundColor = '#8c95a04f';
        }
    });


    async function prepareDiagramPointerImages(formData, responses) {
        const promises = responses.map((q) => {
            if (q.question_type !== 'diagram_pointer') return Promise.resolve();

            try {
                const value = JSON.parse(q.selected_option_text);
                const imageUrl = value.image;
                const pointers = value.pointers || [];

                if (!imageUrl || !pointers.length) return Promise.resolve();

                return new Promise((resolve) => {
                    const base = new Image();
                    base.crossOrigin = "anonymous";
                    base.src = imageUrl;

                    base.onload = () => {
                        const originalWidth = base.width;
                        const originalHeight = base.height;

                        const tempCanvas = document.createElement("canvas");
                        tempCanvas.width = originalWidth;
                        tempCanvas.height = originalHeight;
                        const ctx = tempCanvas.getContext("2d");

                        ctx.drawImage(base, 0, 0);

                        // Get the original drawWidth & drawHeight from data-* attributes if available
                        // OR fall back to 500x500 (but better to set data-canvas-width/height in your HTML!)
                        const dummyCanvas = document.querySelector(
                            `canvas[data-image="${imageUrl}"]`);
                        const drawWidth = dummyCanvas?.width || 500;
                        const drawHeight = dummyCanvas?.height || 500;

                        // Scale markers correctly
                        const scaledMarkers = pointers.map(p => ({
                            x: (p.x / drawWidth) * originalWidth,
                            y: (p.y / drawHeight) * originalHeight
                        }));

                        scaledMarkers.forEach(m => {
                            ctx.save();
                            ctx.beginPath();
                            ctx.shadowBlur = 10;
                            ctx.shadowColor = "rgba(255, 0, 0, 0.3)";
                            ctx.fillStyle = "rgba(255, 0, 0, 0.45)";
                            ctx.arc(m.x, m.y, 22, 0, Math.PI * 2);
                            ctx.fill();
                            ctx.restore();
                        });

                        tempCanvas.toBlob((blob) => {
                            if (blob) {
                                const filename =
                                    `image_file_question_${q.question_id}${Date.now()}-ws.png`;
                                formData.append(`file_question_${q.question_id}`, blob,
                                    filename);
                            }
                            resolve();
                        }, 'image/png');
                    };

                    base.onerror = () => resolve(); // fail-safe
                });
            } catch {
                return Promise.resolve();
            }
        });

        await Promise.all(promises);
    }
</script>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        var appStyle = document.getElementById('app-style');
        if (appStyle && appStyle.href.includes('app-dark.min.css')) {
            var elements = document.querySelectorAll('.sub-question-group');
            elements.forEach(function(el) {
                el.style.backgroundColor = '#8c95a04f';
            });
        }
    });
</script>
