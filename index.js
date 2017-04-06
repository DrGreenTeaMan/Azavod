/**
 * Created by ilaevsin on 04.04.17.
 */

var data = {
    skip: 0,
    limit: 5
};

$(function () {

    get_worker(get_data());

    $("#male_check").on('click', function () {
        $("#female_check").prop("checked", false);
        clear();
        get_worker(get_data());
    });

    $("#female_check").on('click', function () {
        $("#male_check").prop("checked", false);
        clear();
        get_worker(get_data());
    });

    $('#search_button').on('click', function () {
        clear();
        get_worker(get_data());
    });

    $(".pagination").bootpag({}).on('page', function (event, num) {
        data.skip = (num - 1) * data.limit;
        get_worker(get_data());
    });
});

function age(date) {
    var nowYear = new Date().getFullYear();
    var nowMonth = new Date().getMonth();
    var age = date.split('-');
    var currentAge = nowYear - parseInt(age[0]);

    if (nowMonth < parseInt(age[1])) {
        currentAge -= 1;
    }

    if (currentAge % 10 === 0 || (currentAge >= 11 && currentAge <= 19)) {
        return currentAge + " лет";
    } else if (currentAge % 10 === 1) {
        return currentAge + " год";
    } else if (currentAge % 10 < 5 && currentAge % 10 > 1) {
        return currentAge + " года";
    } else {
        return currentAge + " лет";
    }
}


function get_data() {

    // var data = {
    //     skip: 0,
    //     limit: 5
    // };
    var name = $('#search_input').val();
    var age_from = $('#from').val();
    var age_to = $('#To').val();

    if ($('#male_check').prop('checked')) {
        var m_check = $('#male_check').val();
    }

    if ($('#female_check').prop('checked')) {
        var fm_check = $('#female_check').val();
    }

    data.name = name;
    data.age_from = age_from;
    data.age_to = age_to;
    data.m_chek = m_check;
    data.fem_chek = fm_check;

    console.log(data);
    return data;
}

function clear() {
    $(".reestr_table").html("");
}

function get_worker(inf) {

    $.ajax({
        url: '/search_workers.php',
        method: 'POST',
        data: inf,
        dataType: 'json',
        success: function (data) {
            clear();
            var rounded = Math.ceil(data.count / inf.limit);
            $(".pagination").bootpag({
                page: (inf.skip / inf.limit) + 1,
                total: rounded,
                maxVisible: 10,
                leaps: true,
                firstLastUse: true,
                first: '←',
                last: '→',
                wrapClass: 'pagination',
                activeClass: 'active',
                disabledClass: 'disabled',
                nextClass: 'next',
                prevClass: 'prev',
                lastClass: 'last',
                firstClass: 'first'
            });
            $.each(data.data, function (key, value) {
                var html = "";
                html += "<tr>" +
                    "<td>" + value.id + "</td>" +
                    "<td><img src='" + value.file_path + "' class='image'></td>" +
                    "<td>" + value.surname + " " + value.name + " " + value.patronymic + "</td>" +
                    "<td>" + age(value.date_birthday) + "</td>";
                if (value.gender === 'male') {
                    html += "<td style='color: #006dcc'>Муж.</td>";
                } else {
                    html += "<td style='color: deeppink'>Жен.</td>"
                }
                html += "<td>" +
                    "<a href='add_worker.php?id=" + value.id + "'>Ред.</a>" +
                    "<a href='del.php?id=" + value.id + "'>Удал.</a>" +
                    "</td>" +
                    "</tr>";

                $(".reestr_table").append(html);
            });
        }
    });

}
