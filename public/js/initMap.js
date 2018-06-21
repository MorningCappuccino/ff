
var host = window.location.host;

$(document).ready(function(){
    var ymaps = null;
    if(!ymaps)
    {
        $.getScript('https://api-maps.yandex.ru/2.1/?lang=RU');
    }

        $('.cinema .ymap').on('click', function(){

            var lat = $(this).data('lat');
            var lon = $(this).data('lon');

            console.log(lat, lon);

            $('#map_container').empty();
            $.fancybox.open({
                touch: false,
                src: '#map_container',
            });
            $('#map_container').css('height', '80%');

            initMap(lat, lon);
        })
})

function initMap(lat, lon)
{
    var myMap = new ymaps.Map('map_container', {
        center: [lat, lon],
        zoom: 18
    });
    markers = myMap.geoObjects;
    var marker = new ymaps.Placemark([lat, lon], {}, {
        iconLayout: 'default#image',
        iconImageSize: [32, 42],
        iconImageHref: 'http://' + host +'/img/map.svg'
    });
    markers.add(marker);
}
