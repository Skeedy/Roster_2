import {Component, Input, OnInit} from '@angular/core';
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import {Router} from '@angular/router';

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

  constructor(private fb: FormBuilder, private auth: AuthService, private router: Router) { }

  ngOnInit(): void {
    this.loginForm = this.fb.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
    });
  }
  login() {
    this.connexionFailed = false;
    this.loading = true;
    const val = this.loginForm.value;
    if (val.username && val.password) {
      this.auth.login(val.username, val.password)
        .subscribe(
          () => {
            this.auth.profile()
              .subscribe(
                (user) => {
                  this.router.navigate(['/product']);
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
