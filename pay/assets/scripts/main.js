function menuBtn()
{
    var x = document.getElementById("nav");
    if (x.style.display === "flex")
    {
        x.style.display = "none";
    } else
    {
        x.style.display = "flex";
    }

    let width = window.matchMedia("(max-width: 480px)");
    let body = document.querySelector("body");

    if (width.matches)
    {
        if (body.style.overflow === "hidden")
        {
            body.style.overflow = "auto";
        } else
        {
            body.style.overflow = "hidden";
        }
        ;
    }
    ;
}

function BarChange(x)
{
    x.classList.toggle("change");
}

function colHeight()
{
    let width = window.matchMedia("(max-width: 768px)");
    let tableCol2 = document.querySelectorAll(".table-col-2");
    let arr = Array.from(tableCol2);
    let maxHeightArr = [];
    if (width.matches)
    {
        for (let i = 0; i < arr.length; i++)
        {

            let tableMaxHeight = arr[i].offsetHeight;
            maxHeightArr.push(tableMaxHeight);
            arr[i].style.height = "newHeight"
        }
    }

    for (let i = 0; i < arr.length; i++)
    {

        let newHeight = Math.max.apply(null, maxHeightArr) + "px";
        let a = document.querySelectorAll(".table-col-2");
        a[i].style.flex = `0 0 ${newHeight}`;
    }

}

function getSearchParameters()
{
    var prmstr = window.location.search.substr(1);
    return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
}

function transformToAssocArray(prmstr)
{
    var params = {};
    var prmarr = prmstr.split("&");
    for (var i = 0; i < prmarr.length; i++)
    {
        var tmparr = prmarr[i].split("=");
        params[tmparr[0]] = tmparr[1];
    }
    return params;
}

window.onload = function ()
{
    colHeight();
    if (getTotalLeft() == 0)
    {
        document.getElementById('payPercentWithLoan').setAttribute('disabled', '');
        document.getElementById('payAll').setAttribute('disabled', '');
    }
    loanSumChange(document.getElementById('user-entered-sum'));
    if (err == 1)
        swal("Заявка на добор успешно отправлена");
    else if (err == 2)
    {
        swal("Функция подача заявки на добор доступна до 22:00");
    }
    else if (err == 3)
    {
        swal("Не удалось обработать запрос. Неверная сумма.");
    }
    else if (err == 4)
    {
        swal("Не удалось обработать запрос. Недостаточно параметров.");
    }
    window.history.replaceState({}, document.title, "/pay?ticket_id=" + getSearchParameters()['ticket_id']);
};

"use strict";

(function ()
{
    let originalPositions = [];
    let daElements = document.querySelectorAll('[data-da]');
    let daElementsArray = [];
    let daMatchMedia = [];
    //Заполняем массивы
    if (daElements.length > 0)
    {
        let number = 0;
        for (let index = 0; index < daElements.length; index++)
        {
            const daElement = daElements[index];
            const daMove = daElement.getAttribute('data-da');
            if (daMove != '')
            {
                const daArray = daMove.split(',');
                const daPlace = daArray[1] ? daArray[1].trim() : 'last';
                const daBreakpoint = daArray[2] ? daArray[2].trim() : '767';
                const daType = daArray[3] === 'min' ? daArray[3].trim() : 'max';
                const daDestination = document.querySelector('.' + daArray[0].trim())
                if (daArray.length > 0 && daDestination)
                {
                    daElement.setAttribute('data-da-index', number);
                    //Заполняем массив первоначальных позиций
                    originalPositions[number] = {
                        "parent": daElement.parentNode,
                        "index": indexInParent(daElement)
                    };
                    //Заполняем массив элементов 
                    daElementsArray[number] = {
                        "element": daElement,
                        "destination": document.querySelector('.' + daArray[0].trim()),
                        "place": daPlace,
                        "breakpoint": daBreakpoint,
                        "type": daType
                    }
                    number++;
                }
            }
        }
        dynamicAdaptSort(daElementsArray);

        //Создаем события в точке брейкпоинта
        for (let index = 0; index < daElementsArray.length; index++)
        {
            const el = daElementsArray[index];
            const daBreakpoint = el.breakpoint;
            const daType = el.type;

            daMatchMedia.push(window.matchMedia("(" + daType + "-width: " + daBreakpoint + "px)"));
            daMatchMedia[index].addListener(dynamicAdapt);
        }
    }

    //Основная функция
    function dynamicAdapt(e)
    {
        for (let index = 0; index < daElementsArray.length; index++)
        {
            const el = daElementsArray[index];
            const daElement = el.element;
            const daDestination = el.destination;
            const daPlace = el.place;
            const daBreakpoint = el.breakpoint;
            const daClassname = "_dynamic_adapt_" + daBreakpoint;

            if (daMatchMedia[index].matches)
            {
                //Перебрасываем элементы
                if (!daElement.classList.contains(daClassname))
                {
                    let actualIndex = indexOfElements(daDestination)[daPlace];
                    if (daPlace === 'first')
                    {
                        actualIndex = indexOfElements(daDestination)[0];
                    } else if (daPlace === 'last')
                    {
                        actualIndex = indexOfElements(daDestination)[indexOfElements(daDestination).length];
                    }
                    daDestination.insertBefore(daElement, daDestination.children[actualIndex]);
                    daElement.classList.add(daClassname);
                }
            } else
            {
                //Возвращаем на место
                if (daElement.classList.contains(daClassname))
                {
                    dynamicAdaptBack(daElement);
                    daElement.classList.remove(daClassname);
                }
            }
        }
        customAdapt();
    }

    //Вызов основной функции
    dynamicAdapt();

    //Функция возврата на место
    function dynamicAdaptBack(el)
    {
        const daIndex = el.getAttribute('data-da-index');
        const originalPlace = originalPositions[daIndex];
        const parentPlace = originalPlace['parent'];
        const indexPlace = originalPlace['index'];
        const actualIndex = indexOfElements(parentPlace, true)[indexPlace];
        parentPlace.insertBefore(el, parentPlace.children[actualIndex]);
    }

    //Функция получения индекса внутри родителя
    function indexInParent(el)
    {
        var children = Array.prototype.slice.call(el.parentNode.children);
        return children.indexOf(el);
    }

    //Функция получения массива индексов элементов внутри родителя
    function indexOfElements(parent, back)
    {
        const children = parent.children;
        const childrenArray = [];
        for (let i = 0; i < children.length; i++)
        {
            const childrenElement = children[i];
            if (back)
            {
                childrenArray.push(i);
            } else
            {
                //Исключая перенесенный элемент
                if (childrenElement.getAttribute('data-da') == null)
                {
                    childrenArray.push(i);
                }
            }
        }
        return childrenArray;
    }

    //Сортировка объекта
    function dynamicAdaptSort(arr)
    {
        arr.sort(function (a, b)
        {
            if (a.breakpoint > b.breakpoint)
            {
                return -1
            } else
            {
                return 1
            }
        });
        arr.sort(function (a, b)
        {
            if (a.place > b.place)
            {
                return 1
            } else
            {
                return -1
            }
        });
    }

    //Дополнительные сценарии адаптации
    function customAdapt()
    {
        //const viewport_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    }

}());

function getTotalLeft()
{
    var total = loan + percent - payed;
    return total;
    //document.getElementById('totalLeftSum').innerText = (total <=0?0:total)+" ₽";
}

function loanSumChange(e)
{
    if (e == null) return;
    var result = 0;
    var enteredSum = parseFloat(e.value == '' ? '0' : e.value);
    if(enteredSum<50)
        enteredSum = 50;
    enteredSum = Math.abs(enteredSum);
    enteredSum = (Math.floor(enteredSum / 50) * 50);
    if (payed == 0)
    {
        result = enteredSum + percent;
    } else
    {
        result = enteredSum;
    }
    if (result > loan + percent - payed - 150)
    {
        result = loan + percent - payed - 150;
    }
    document.getElementById('totalSum').value = document.getElementById('enteredSum').value = Math.round((result * 100))/100;
}

function showAvailablePopup()
{
    var span = document.getElementById('availablesumpopuptext');
    var left = payed - percent;
    if(left<0)
        left = percent;
    else
        left = 0;
    var sum = document.getElementsByClassName('ctrl__counter-input')[0].value - left;
    sum =  Math.round((sum * 100))/100;
    var text = "Вы действительно хотите произвести добор на сумму " + sum + " рублей с выводом на карту: " + card_number + "?";
    var node = document.createTextNode(text);
    span.innerHTML = '';
    span.appendChild(node);
    document.getElementById('availableamount').value = document.getElementsByClassName('ctrl__counter-input')[0].value;
    if (sum > 0)
    {
        document.getElementById('available_popup_visible').checked = true;
    } else
    {
        swal("Добор - процент не может быть меньше 0");
    }
}

function showtip()
{
    swal('Для оплаты части займа можно использовать только суммы, кратные 50');
}

function showtip1()
{
    if (payed < percent)
        swal('С Вас будет удержан неоплаченный % по зйму');
}