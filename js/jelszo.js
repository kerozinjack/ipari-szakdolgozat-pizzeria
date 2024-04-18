function $_(id){
    return document.getElementById(id)
}

//jelszo
let pw = $_("password-input");

if(pw!=null){
    let pw_mutasd = document.querySelector(".show-passwd");
    
    pw_mutasd.addEventListener('click', () => {
        // console.log(pw);
        // console.log(pw.value);
        pw_mutasd.classList.toggle('fa-eye');
        pw_mutasd.classList.toggle('fa-eye-slash');
        
        if (pw.type === 'password') {
            pw.type = 'text';
        } else {
            pw.type = 'password';
        }
    });
}

//jelszo megerosites
let mpw = $_("password-confirm");

if(mpw!=null){
    let mpw_mutasd = document.querySelector(".show-passwd-c");
    
    mpw_mutasd.addEventListener('click', () => {
        mpw_mutasd.classList.toggle('fa-eye');
        mpw_mutasd.classList.toggle('fa-eye-slash');
        
        if (mpw.type === 'password') {
            mpw.type = 'text';
        } else {
            mpw.type = 'password';
        }
    });
}

//regi jelszo
let opw = $_("old-password-input");

if(opw!=null){
    let opw_mutasd = document.querySelector(".show-passwd-o");
        
    opw_mutasd.addEventListener('click', () => {
    
        opw_mutasd.classList.toggle('fa-eye');
        opw_mutasd.classList.toggle('fa-eye-slash');
    
        if (opw.type === 'password') {
            opw.type = 'text';
        } else {
            opw.type = 'password';
        }
    });
}


let form=$_("regisztralo");

if(form!=null){

    //ellenorzes
    let regex_mintak=[
        {regex: /.{8,}/ },
        {regex: /[0-9]/ },
        {regex: /[a-z]/ },
        {regex: /[A-Z]/ },
        {regex: /[^A-Za-z0-9]/}
    ]
    
    
    let feltetelek=document.querySelectorAll('.list-item');
    
    
    pw.addEventListener('keyup', ()=>{
        let tovabbithato=true;
        for(let i=0;i<regex_mintak.length;i++){
            let regex_minta=regex_mintak[i]
            let eros=regex_minta.regex.test(pw.value);
            // console.log(eros);
            if(!eros){
                tovabbithato=false;
            }
            if(eros){
                feltetelek[i].classList.add('checked');
            }
            else{
                feltetelek[i].classList.remove('checked');
            }
        }
        
        if(tovabbithato){
            form.classList.add('jo');
        }
        else{
            form.classList.remove('jo');    
        }
    })

    form.addEventListener('submit',function(event){
        if(!form.classList.contains('jo')){
            event.preventDefault();
            alert("Nem elég erős jelszó!");
        }
    });
}
