$(document).ready(function(){

    //tablePaginate.init();

    var oTable = $('#product-table').dataTable({
        "paging": true
    });
    oTable.fnSort( [ [0,'desc'] ] );

    tableManager.init();
    tableManager.setActiveOnClick();
    tableManager.addFileSelector('.cms_thumb');
});

var tableManager = function(){
    'use strict';
    var target = $('table.table'), rows = [];
    return {

        init:function(){
            rows = target.children('tbody').children('tr');
        },

        setActiveOnClick: function(){
            rows.click(function(){
                rows.each(function(){ $(this).removeClass('activeRow'); });
                $(this).addClass('activeRow');
            });
        },

        addFileSelector:function( selector ){
            if( ! fileSelector ){ console.log('Function "fileSelector" not found.'); return false; }
            var targets = $(selector);
            if( targets.length === 0 || targets.first().prop('tagName') !== 'IMG' ){ console.log('Wrong selector.'); return false; }

            targets.click(function(){
                fileSelector.init( $(this).parents('tr').data('role'), this );
                fileSelector.showPopUp();
            });
        }

    };
}();

var tablePaginate = function() {
    "use strict";
    var total = 0, target = $('table.table'), currentPage = 1, rows = [];

    var p_options = { perPage: 3, expandIn:105 };

  return {

      init:function(){
          rows = target.children('tbody').children('tr');
          total = rows.length;

          if( total > p_options.perPage ){
              this.paginate();
          }
              target.removeClass('hidden');
      },

      mel:function(tag){
        return document.createElement(tag);
      },

      paginate:function(  ){
          if(this.makeNavigation( p_options.perPage )){
              this.showPage( $('.page-buttons').find('li').eq(1) );
          }
      },

      makeNavigation:function( pages ){
          if( ! $('.page-buttons') ){
              return false;
          }
          var cnt = $('.page-buttons'), nav = this.mel('nav'), ul = this.mel('ul'), that = this;

          ul.setAttribute('class','pagination');
          nav.appendChild(ul);
          cnt.append(nav);

          var pr = this.mel('li'), nt = this.mel('li'), pr_a = this.mel('a'), nt_a = this.mel('a');

              pr_a.setAttribute( 'aria-label', 'Previous' );
              nt_a.setAttribute( 'aria-label', 'Next' );

          var pr_s = this.mel('span'),                  nt_s = this.mel('span');
              pr_s.innerHTML = '&raquo;';               nt_s.innerHTML = '&laquo;';
              pr_s.setAttribute('aria-hidden', 'true'); nt_s.setAttribute('aria-hidden', 'true');

                pr.appendChild(pr_a).appendChild( pr_s );
                nt.appendChild(nt_a).appendChild( nt_s );

          nt.addEventListener( 'click', function(){ that.showPage( 'up' ) }, false );
          pr.addEventListener( 'click', function(){ that.showPage( 'down' ) }, false );

          ul.appendChild(nt);
            for( var i=0; i<total/pages; i++ ){
                var li = this.mel('li'), a = this.mel('a');
                a.innerHTML = (i+1);
                li.appendChild( a ); li.addEventListener( 'click', function(){ that.showPage( this ); }, false);
                ul.appendChild(li);
            }
          ul.appendChild(pr);

          return true;
      },

      showPage:function( need ){

          if( need === 'up' || need === 'down' ){
               var curr = $('ul.pagination li.active');
              var index = $(curr).index(), maxTotal = Math.ceil(total / p_options.perPage);

              if( ((index === maxTotal) && need === 'down' ) ||
                  ((index === 1) && need === 'up' )){ return false;}

              if( need === 'down' ){
                  need = $(curr).next();
              }else {
                  need = $(curr).prev();
              }
          }

          var go_on = $(need).find('a').text(), counter = 0;

          if( go_on <= 0 || go_on > maxTotal ){
              return false;
          }

          $(need).parent('ul').find('li').removeClass('active');
          $(need).addClass('active');

          currentPage = go_on; go_on--; rows.addClass('hidden');

          for( var i = go_on*p_options.perPage; i < ( currentPage*p_options.perPage ) && i < total; i++ ){
              setTimeout(function(x) { return function() { $(rows[x]).removeClass('hidden'); }; }(i), p_options.expandIn*(++counter));
          }
      }

  };

}();