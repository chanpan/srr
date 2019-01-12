<?php
 
namespace janpan\jn\widgets;
use yii\helpers\Html; 
class CNSearchWidget extends \yii\base\Widget{
    public $data=[];
    public $labelSelect= 'ดูตามประเภท';
    public $btnClass = 'btn btn-primary';
    public $customBtnStyle = '';
    public $customInputStyle='';
    public $customDropDownStyle = '';
    public function init() {
        parent::init();
    }
    public function run() {
        parent::run();
        $html = "";
        $html .= '
              <form class="row searchFilter" id="form-global-search" >
                 <div class="col-sm-12" >
                  <div class="input-group" >
                   <input style="'.$this->customInputStyle.'" id="text-search-term" type="text" id="text_search_params" class="form-control" aria-label="Text input with segmented button dropdown" >
                   <input type="hidden" name="text-search-id" id="text-search-id"/> 
                    <div class="input-group-btn" >
                    <button style="'.$this->customDropDownStyle.'" type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><span class="label-icon" >'.$this->labelSelect.'</span> <span class="caret" ></span></button>
                    <div class="dropdown-menu dropdown-menu-right" >
                       <ul class="category_filters" > '; 
                       if(!empty($this->data['types'])){
                           foreach($this->data['types'] as $k=>$t){
                               $name = \Yii::t('section', $t['name']);
                               $html .= "
                                   <li >
                                      <label data-id='{$t['id']}' for='{$name}'>{$name}</label>
                                    </li>
                                "; 
                           }
                       }
        
        
        $html .= "     </ul>
                    </div>
                    <button style='{$this->customBtnStyle}' type='submit' id='searchBtn' class='{$this->btnClass}'><span class='glyphicon glyphicon-search >&nbsp;</span> <span class='label-icon ></span></button>
                   </div>
                  </div>
                 </div>
              </form>    
        ";        
        $this->registerScript();
        echo $html;
    }
    public function registerScript(){
        $view = $this->getView(); 
        $js="
            
            
            $('#text-search-id').val('');
            $('.category_filters li label').on('click', function(){
                let label = $(this).text();
                let id = $(this).attr('data-id');
                $('#text-search-id').val(id);
                $('.label-icon').text(label);
                //return false;
            });
            
            $('#form-global-search').on('submit', function(){
                
                let term = $('#text-search-term').val();
                let type_id = $('#text-search-id').val();
                let url = '".\yii\helpers\Url::to(['/sections/session-management/search?type_id='])."'+type_id+'&txtsearch='+term;
                window.open(url,'_parent');
                return false;
            });
            
            $( '#text-search-term').autocomplete({
                    source: function( request, response ) {
                      $.ajax( {
                        url: '".\yii\helpers\Url::to(['/sections/session-management/get-keyword-search'])."',
                        dataType: 'json',
                        data: {
                          term: request.term
                        },
                        success: function( data ) {
                          response( data );
                        }
                      } );
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                    let type_id = $('#text-search-id').val();
                    let url = '".\yii\helpers\Url::to(['/sections/session-management/search?type_id='])."'+type_id+'&txtsearch='+ui.item.value;
                    window.open(url,'_parent');
                  }
            });

        ";
        
        $view->registerJs($js);
        $css ="
           .ui-menu .ui-menu-item{
            
           }
           .ui-menu .ui-menu-item {
                background: #57a19f;
            }
           .searchFilter.btn {
              display: inline-block;
              font-weight: 400;
              line-height: 1.25;
              text-align: center;
              white-space: nowrap;
              vertical-align: middle;
              cursor: pointer;
              -webkit-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
              border: 1px solid transparent;
              padding: .5rem 1rem;
              font-size: 16px;
              border-radius: .25rem;
              height: 50px;
              min-width: 20px;
          }
          .searchFilter .btn-secondary {
              color: #373a3c;
              background-color: #fff;
              border: 1px solid #ccc;
          }
          .searchFilter .btn-secondary:hover {
              color: #373a3c;
              background-color: #e6e6e6;
              border-color: #adadad;
          }
          .searchFilter .btn-search {
            background-color: #00aced;
            color: #fff;
            border: 1px solid #00aced;
          }
          .searchFilter .btn-search:hover {
            background-color: #b20a11;
            color: #fff;
            border: 1px solid #b20a11;
          }
          .searchFilter .label-icon {
            display: none;  
          }
          .searchFilter .glyphicon {
              margin-right: -15px;
          }
          .searchFilter .dropdown-menu .category_filters {
            min-width: 178px;
            width: 100%;
            margin: 15px 0 0 -45px;
          }
          .searchFilter .dropdown-menu-right {
              right: 170px;
              min-width: 175px;
                  top: 90%;
          }
          .searchFilter .dropdown-menu .category_filters li {
            list-style-type: none;
            padding: 2px 25px;
            font-size: 18px;
          }
          .searchFilter .dropdown-menu .category_filters label {
            color: #fff;
            margin-left: 35px;
            font-size: 16pt;
          }
          @media (min-width: 1400px) {
            .ct-header .ct-jumbotron .inner {
              max-width: 470px;
              min-height: 230px;
            }  
          }
          @media (max-width: 1400px) {
            .ct-header-slider .item {
              background-size:contain;
              background-repeat: no-repeat;
              background-position: center top;
            }  
          }
          @media (min-width: 769px) and (max-width: 1400px) {
            .ct-header-slider .item {
              height: auto;  
            }
          }
          @media (max-width: 1260px) {
            #dots-container {
              display: none;
            }
          }
          @media (min-width: 992px){
            .ct-footer2 .ct-newsletter {
              max-width: 100%;
            }
            #dots-container {
              bottom: 100px;
            } 
          }
          @media (min-width: 768px){
            .ct-searchbar:before {
              height: 92px;
              bottom: -1px;
            }
            .page-scrolled .navbar .navbar-nav li > * {
              min-height: 67px;
              height: 67px;
            }
            .page-scrolled .navbar .navbar-nav {
              height: 100%!important;
            }
            .ct-current-facts h2 {
              margin: 0 auto 0px;
            }
            .contentNews .ct-recent-news {
              flex-direction: inherit;
            }
            .contentFaq .faq_question .col-sm-11 {
              padding-right: 0px;
            }
            .peopleDetail h2 {
              margin-top: -5px;
            }
            .searchFilter .btn {
              min-width: 172px;  
            }
            .searchFilter .label-icon {
              display: inline-block;  
              font-weight: bold;
              color: #4d2655;
            }
            .searchFilter .glyphicon {
              margin-right: 15px;
            }
            .ct-header .ct-jumbotron {
              top: 0;
              margin-top: 5%;
            }
            .ct-header .ct-jumbotron h1 {
              font-size: 2.5em;
            }
            .ct-news.ct-news--bigger h3 {
              font-size: 41px;
              line-height: 1.4;
            }
          }
          @media (max-width: 768px){
            .ct-header .ct-jumbotron {  
              width: 80%;
              margin: 20px 10px;
              top: 40%;
              width: 95%;
            }
            .ct-header .ct-jumbotron .inner {
              max-width: 100%;
            }
            #dots-container {
              display: none;
            }
            .main-section {
              margin-top: -80px;
            }
            .searchFilter .dropdown-menu-right {
                  right: 0px;
            }
          }
          
         @media screen and (max-width:768px){
           
                .searchFilter .glyphicon {
                    margin-right: 4px;
                }
                button#searchBtn {
                    width: 50px;
                }
           }
           
    #searchBtn .glyphicon {
        position: relative;
        top: 5px;
    }

        ";
        $view->registerCss($css);
    }
}
