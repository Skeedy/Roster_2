import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import { MustMatch} from "../../functions/must-match.validator";
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-new-roster',
  templateUrl: './new-roster.component.html',
  styleUrls: ['./new-roster.component.scss']
})
export class NewRosterComponent implements OnInit {

  public registerFailed: boolean;
  public registrationDone: boolean;
  public loading: boolean;
  private registerForm: FormGroup;
  public html: string;

  constructor(private fb: FormBuilder, private authServ: AuthService, private  rosterServ : RosterService) { }

  ngOnInit() {
    this.registerForm = this.fb.group({
        rostername: [ null, Validators.required ],
        password: new FormControl('', Validators.compose([
          Validators.required,
          Validators.pattern('^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d]{8,}$')
        ])),
        confirmPassword: [ null, Validators.required],
        email: new FormControl('', Validators.compose([
          Validators.required,
          Validators.pattern('^(([^<>()\\[\\]\\.,;:\\s@\\"]+(\\.[^<>()\\[\\]\\.,;:\\s@\\"]+)*)|(\\".+\\"))@(([^<>()[\\]\\.,;:\\s@\\"]+\\.)+[^<>()[\\]\\.,;:\\s@\\"]{2,})$')
        ]))
      },
      { validator: MustMatch('password', 'confirmPassword')
      });
  }

  get password() {
    return this.registerForm.get('password');
  }
  get f() { return this.registerForm.controls; }
  register() {
    const val = this.registerForm.value;
    this.loading = true;
    this.rosterServ.register(val).subscribe( () => {
      this.loading = false;
      this.registrationDone = true;
      this.html ='success'
    }, (err) => {
      this.html = err.error.response;
      this.loading = false;
      this.registerFailed = true;
    });
  }
}
