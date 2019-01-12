    $(function(){      
       //水平方向右滑动轮播
       $('.a').jCarousel({
          type:'slidex-right',
          carsize: {carwidth:700,carheight:150},
       });
       //水平方向左滑动轮播
       $('.b').jCarousel({
          type:'slidex-left',
          carsize: {carwidth:700,carheight:150},
       });       
       //垂直方向下滑动轮播
       $('.c').jCarousel({
          type:'slidey-down',
          carsize: {carwidth:600,carheight:400},
       });
       //垂直方向上滑动轮播
       $('.d').jCarousel({
          type:'slidey-up',
          carsize: {carwidth:600,carheight:400},
       });       
       //水平方向渐隐轮播
       $('.e').jCarousel({
          type:'opacx',
          carsize: {carwidth:500,carheight:300},
       });
       //垂直方向渐隐轮播
       $('.f').jCarousel({
          type:'opacy',
          carsize: {carwidth:500,carheight:300},
       });
    }); 