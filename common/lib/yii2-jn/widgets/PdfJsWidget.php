<?php
 
namespace janpan\jn\widgets;
use yii\helpers\Html; 
class PdfJsWidget extends \yii\base\Widget{
     
    public function run() {
        $demo = \Yii::getAlias('@storage').'/web/files/1536390899000085100/444a0a3253a5a1dd0ac06b25ed8a1c08.pdf';
        $template = "
            <button id='upload-button'>Select PDF</button> 
            <input type='file' id='file-to-upload' accept='application/pdf' value='{$demo}'/>
            <div id='pdf-main-container'>
                <div id='pdf-loader'>Loading document ...</div>
                <div id='pdf-contents'>
                        <div id='pdf-meta'>
                                <div id='pdf-buttons'>
                                        <button id='pdf-prev'>Previous</button>
                                        <button id='pdf-next'>Next</button>
                                </div>
                                <div id='page-count-container'>Page <div id='pdf-current-page'></div> of <div id='pdf-total-pages'></div></div>
                        </div>
                        <canvas id='pdf-canvas' width='400'></canvas>
                        <div id='page-loader'>Loading page ...</div>
                </div>
        </div>
        ";
        $this->registerScript();
        echo $template;
    }
    public function registerScript(){
        
         
        $view = $this->getView();
        \janpan\jn\assets\pdfjs\PdfJsAssets::register($view); 
        $js="
             
            var __PDF_DOC,
                    __CURRENT_PAGE,
                    __TOTAL_PAGES,
                    __PAGE_RENDERING_IN_PROGRESS = 0,
                    __CANVAS = $('#pdf-canvas').get(0),
                    __CANVAS_CTX = __CANVAS.getContext('2d');
                    
            setTimeout(function(){
                console.log(URL.createObjectURL($('#file-to-upload').get(0).files[0]));
                console.log($('#file-to-upload').get(0).files[0]);
            },1000);        

            function showPDF(pdf_url) {
                    
                    $('#pdf-loader').show();
                    
                    PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
                            __PDF_DOC = pdf_doc;
                            __TOTAL_PAGES = __PDF_DOC.numPages;

                            // Hide the pdf loader and show pdf container in HTML
                            $('#pdf-loader').hide();
                            $('#pdf-contents').show();
                            $('#pdf-total-pages').text(__TOTAL_PAGES);

                            // Show the first page
                            showPage(1);
                    }).catch(function(error) {
                            // If error re-show the upload button
                            $('#pdf-loader').hide();
                            $('#upload-button').show();

                            alert(error.message);
                    });;
            }

            function showPage(page_no) {
                    __PAGE_RENDERING_IN_PROGRESS = 1;
                    __CURRENT_PAGE = page_no;

                    // Disable Prev & Next buttons while page is being loaded
                    $('#pdf-next, #pdf-prev').attr('disabled', 'disabled');

                    // While page is being rendered hide the canvas and show a loading message
                    $('#pdf-canvas').hide();
                    $('#page-loader').show();

                    // Update current page in HTML
                    $('#pdf-current-page').text(page_no);

                    // Fetch the page
                    __PDF_DOC.getPage(page_no).then(function(page) {
                            // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
                            var scale_required = __CANVAS.width / page.getViewport(1).width;

                            // Get viewport of the page at required scale
                            var viewport = page.getViewport(scale_required);

                            // Set canvas height
                            __CANVAS.height = viewport.height;

                            var renderContext = {
                                    canvasContext: __CANVAS_CTX,
                                    viewport: viewport
                            };

                            // Render the page contents in the canvas
                            page.render(renderContext).then(function() {
                                    __PAGE_RENDERING_IN_PROGRESS = 0;

                                    // Re-enable Prev & Next buttons
                                    $('#pdf-next, #pdf-prev').removeAttr('disabled');

                                    // Show the canvas and hide the page loader
                                    $('#pdf-canvas').show();
                                    $('#page-loader').hide();
                            });
                    });
            }

            // Upon click this should should trigger click on the #file-to-upload file input element
            // This is better than showing the not-good-looking file input element
            $('#upload-button').on('click', function() {
                
                $('#file-to-upload').trigger('click');
            });

            // When user chooses a PDF file
            $('#file-to-upload').on('change', function() {
                     
                if(['application/pdf'].indexOf($('#file-to-upload').get(0).files[0].type) == -1) {
                    alert('Error : Not a PDF');
                    return;
                }

                    $('#upload-button').hide();
                    console.log(URL.createObjectURL($('#file-to-upload').get(0).files[0]));
                    console.log($('#file-to-upload').get(0).files[0]);
                    
                     
                    showPDF(URL.createObjectURL($('#file-to-upload').get(0).files[0]));
            });

            // Previous page of the PDF
            $('#pdf-prev').on('click', function() {
                    if(__CURRENT_PAGE != 1)
                            showPage(--__CURRENT_PAGE);
            });

            // Next page of the PDF
            $('#pdf-next').on('click', function() {
                    if(__CURRENT_PAGE != __TOTAL_PAGES)
                            showPage(++__CURRENT_PAGE);
            });

        ";
        $view->registerJs($js);
        
    }
}
