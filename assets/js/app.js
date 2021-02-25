
// Main controller for all Ajax requests
const SCHEDULE_HOST = 'http://localhost/learning/rozklad';

window.onload = (event) => {
    // let clickHandler = ("ontouchstart" in window ? "touchend" : "click");

    $('.lesson-info').on('mouseup', (e) => {
        let infoBox = $('.zoom-info-box')[0];

        let resultInput = '';

        $.ajax({
            type: "POST",
            url: 'index.php',
            data: { idGroup: e.currentTarget.children.namedItem('lesson-id').value, 
                    week: e.currentTarget.children.namedItem('lesson-week').value 
                    },
            success: function(response)
            {
                let jsonData = JSON.parse(response);

                // Код не очень, следует строить dom элементы
                if(jsonData.error == '') {
                    if(jsonData.zoomInfo)
                    {
                        let zoomIdInput = '';
                        if(jsonData.zoomInfo.zoom_id)
                        {
                            zoomIdInput = $(`<input type="text" id='zoom-id' value="${jsonData.zoomInfo.zoom_id}" onload="" onClick="copyZoomId(this)" readonly>`);
                            zoomIdInput[0].style.width = ((zoomIdInput[0].value.length + 1) * 8) + 'px';
                            zoomIdInput = zoomIdInput[0].outerHTML;
                        }

                        let zoomPassInput = '';
                        if(jsonData.zoomInfo.zoom_pass)
                        {
                            zoomPassInput = $(`<input type="text" id='zoom-pass' value="${jsonData.zoomInfo.zoom_pass}" onClick="copyZoomPass(this)" readonly>`);
                            zoomPassInput[0].style.width = ((zoomPassInput[0].value.length + 1) * 8) + 'px';
                            zoomPassInput = zoomPassInput[0].outerHTML;
                        }

                        let zoomLink = `<div id="all-info"><a target="_blank" href="${jsonData.zoomInfo.zoom_link}">Zoom Link</div></a>`;
                        
                        resultInput = `<b>Ідентифікатор конференції:</b><br>` + zoomIdInput +
                                        `<br><b>Код доступу:</b><br>` + zoomPassInput + zoomLink;
                    }
                    else 
                    {
                        let zoomAll = `<div id="all-info">${jsonData.onlineInfo}</div>`;
                        resultInput = zoomAll;
                    }
                } else {
                    let zoomError = `<div id="error-info">${jsonData.error}</div>`;
                    resultInput = zoomError;
                }

                infoBox.innerHTML = `<span class="button square closer"></span>
                                    <div class="info-box-content">` + resultInput + `</div>`;

                Metro.infobox.create(infoBox.innerHTML);
            }   
        });  
    });
}

function copyZoomId(e) {
    e.focus();
    e.select();
    document.execCommand('copy');
}

function copyZoomPass(e) {
    e.focus();
    e.select();
    document.execCommand('copy');
}