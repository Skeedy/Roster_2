import {Component, Input, OnInit} from '@angular/core';
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import {Router} from '@angular/router';
import {RosterService} from "../../service/roster.service";
import {LoadingService} from "../../service/loading.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm = new FormGroup({
    rostername : new FormControl(''),
    password : new FormControl('')
  });
  public connexionFailed: boolean;
  public loading: boolean;
  public html: string;

  constructor(private fb: FormBuilder, public loadingServ: LoadingService, private rosterServ: RosterService, private router: Router) { }

  ngOnInit(): void {
    this.loginForm = this.fb.group({
      rostername: ['', Validators.required],
      password: ['', Validators.required],
    });
  }
  login() {
    this.loadingServ.activeLoading()
    this.connexionFailed = false;
    this.loading = true;
    const val = this.loginForm.value;
    if (val.rostername && val.password) {
      this.rosterServ.login(val.rostername, val.password)
        .subscribe(
          () => {
            this.rosterServ.getRoster()
              .subscribe(
                (roster) => {
                    this.loadingServ.removeLoading();
                  if(this.rosterServ._rosterSub.value.player.length >= 1) {
                    this.router.navigate(['/roster']);
                  }
                  else if (!this.rosterServ._rosterSub.value.isVerified){
                    this.rosterServ.logout();
                    this.html = "Your account needs to be activated to proceed, please check your email !"
                  }
                  else{
                    this.router.navigate(['/player']);
                  }
                    this.loading = false;
                },
                (err) => {
                  this.loadingServ.removeLoading();
                  this.connexionFailed = true;
                  this.loading = false;
                });
          },
          (data) => {
            console.log(data)
            this.loadingServ.removeLoading();
            this.connexionFailed = true;
            this.loading = false;
            this.html = 'Roster name or Password invalid !'
          } );
    }
  }
}
