document.addEventListener('DOMContentLoaded',function(){
    const most = new Date();
    const tmp_nap = most.getDay();
    let nap;
    switch (tmp_nap) {
        case 0:
            nap=6;
            break;
        case 1:
            nap=0;
            break;
        case 2:
            nap=1;
            break;
        case 3:
            nap=2;
            break;
        case 4:
            nap=3;
            break;
        case 5:
            nap=4;
            break;
        case 6:
            nap=5;
            break;
        default:
            break;
    }

    const ido = most.getHours() * 60 + most.getMinutes();

    const nyitvatartas = {
        0: { nyitas: 0, zaras: 0 },                   // hetfo
        1: { nyitas: 11 * 60, zaras: 19 * 60 + 30 },  // kedd
        2: { nyitas: 11 * 60, zaras: 19 * 60 + 30 },  // szerda
        3: { nyitas: 11 * 60, zaras: 19 * 60 + 30 },  // csutortok
        4: { nyitas: 11 * 60, zaras: 19 * 60 + 30 },  // pentek
        5: { nyitas: 11 * 60, zaras: 19 * 60 + 30 },  // szombat
        6: { nyitas: 0, zaras: 0 }                    // vasarnap
    };

    const nyitvatartasli=document.querySelectorAll(".nyitvatartas li");
    // console.log(nap);

    for (let i = 0; i < nyitvatartasli.length; i++) {
        const item = nyitvatartasli[i];
        const mainap = i;
        
    
        if (mainap === nap) {
            // console.log(mainap);
            const { nyitas, zaras } = nyitvatartas[mainap];
    
            if (ido >= nyitas && ido <= zaras) {
                item.classList.add("open");
            } else if (ido < nyitas) {
                item.classList.add("open-soon");
            } else if (ido >= zaras - 30 && ido < zaras) {
                item.classList.add("closing-soon");
            } else {
                item.classList.add("closed");
            }
        }
    }

    

})