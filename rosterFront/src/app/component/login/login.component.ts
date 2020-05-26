import {Component, Input, OnInit} from '@angular/core';
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import {Router} from '@angular/router';
import {RosterService} from "../../service/roster.service";

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

  constructor(private fb: FormBuilder, private rosterServ: RosterService, private router: Router) { }

  ngOnInit(): void {
    this.loginForm = this.fb.group({
      rostername: ['', Validators.required],
      password: ['', Validators.required],
    });
  }
  login() {
    console.log(this.loginForm.value)
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
                  this.router.navigate(['/roster']);
                  this.loading = false;
                },
                (err) => {
                  console.log(err);
                  this.connexionFailed = true;
                  this.loading = false;
                });
          },
          (err) => {
            console.log(err);
            this.connexionFailed = true;
            this.loading = false;
          } );
    }
  }
}
