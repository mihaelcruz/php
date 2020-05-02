$.fn.scrollEnd = function(callback, timeout) {
  $(this).scroll(function(){
    var $this = $(this);
    if ($this.data('scrollTimeout')) {
      clearTimeout($this.data('scrollTimeout'));
    }
    $this.data('scrollTimeout', setTimeout(callback,timeout));
  });
};

function inicializarSlider(){
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    prefix: "$"
  });
}

function playVideoOnScroll(){
  var ultimoScroll = 0,
      intervalRewind;
  var video = document.getElementById('vidFondo');
  $(window)
    .scroll((event)=>{
      var scrollActual = $(window).scrollTop();
      if (scrollActual > ultimoScroll){
       video.play();
     } else {
        video.play();
     }
     ultimoScroll = scrollActual;
    })
    .scrollEnd(()=>{
      video.pause();
    }, 10)
}

inicializarSlider();
playVideoOnScroll();

$(function(){
  ciudad();
  tipo();
})

function ciudad(){
  $.ajax({
    url:'./ciudad.php',
    type: 'GET',
    data:{},
    success:function(ListaCiudades){
      ListaCiudades = validarJson(ListaCiudades, 'Ciudad')
      $.each(ListaCiudades, function( index, value ) {
        $('#selectCiudad').append('<option value="'+value+'">'+value+'</option>')
      });
    }
  })
}

function tipo(){
  $.ajax({
    url:'./tipo.php',
    type: 'GET',
    data:{},
    success:function(tipoList){
      tipoList = validarJson(tipoList, 'Tipo')
      $.each(tipoList, function( index, value ) {
        $('#selectTipo').append('<option value="'+value+'">'+value+'</option>')
      });
    },
  }).done(function(){
    $('select').material_select();
  })
}

function validarJson(validarJson, lista){
  try {
    var validarJson = JSON.parse(validarJson)
    return validarJson
  } catch (e) {
    error('','SyntaxError '+lista);
    }
}

$('#mostrarTodos').on('click', function(){
  mostrar('todos');
})

$('#formulario').on('submit', function(event){
  event.preventDefault();
  mostrar('filtros');
})

function mostrar(filtrar){
  if($('.colContenido > .item') != 0){
    $('.colContenido > .item').detach()
  }
  var rango = $('#rangoPrecio').val(),
  rango = rango.split(";")
  if (filtrar == 'todos'){
    var ciudad = '',
        tipo = '',
        precio = ''
  }else{
    var ciudad = $('#selectCiudad option:selected').val(),
        tipo = $('#selectTipo option:selected').val(),
        precio = rango
  }
    var filtro = {
      Ciudad: ciudad,
      Tipo: tipo,
      Precio: precio
    }
  $.ajax({
    url:'./buscador.php',
    type: 'GET',
    data:{filtro},
    success:function(items, textStatus, errorThrown ){
      try {
        item = JSON.parse(items);
      } catch (e) {
        error(500,'error servidor');
      }
      $.each(item, function(index, item){
        $('.colContenido').append(
          '<div class="col s12 item">'+
            '<div class="card itemMostrado">'+
              '<img src="./img/home.jpg">'+
                  '<div class="card-content">'+
                    '<p><b>Direccion: </b>'+item.Direccion+'</p>'+
                    '<p><b>Ciudad: </b>'+item.Ciudad+'</p>'+
                    '<p><b>Teléfono: </b>'+item.Telefono+'</p>'+
                    '<p><b>Código postal: </b>'+item.Codigo_Postal+'</p>'+
                    '<p><b>Tipo: </b>'+item.Tipo+'</p>'+
                    '<p><b>Precio: </b><span class="precioTexto">'+item.Precio+'</span></p>'+
                    '<span class="card-title activator">Ver más...</span>'+
                  '</div>'+
                  '<div class="card-reveal">'+
                  '<span class="card-title grey-text text-darken-4">Contáctanos<i class="material-icons right">close</i></span>'+
                  '<p>Para mas información por favor debe contactarse al +591 75797260. </p>'+
                  '</div>'+
                '</div>'+
            '</div>'+
          '</div>'
        )
      })
    },
  }).done(function(){
    var total = $('.colContenido > .item').length
    $('.tituloContenido.card > h5').text("Resultados de la búsqueda: "+ total)
  }).fail(function( jqXHR, textStatus, errorThrown ){
      error(jqXHR, textStatus)
  })
}
