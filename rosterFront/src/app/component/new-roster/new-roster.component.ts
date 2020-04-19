import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import { MustMatch} from "../../functions/must-match.validator";

@Component({
  selector: 'app-new-roster',
  templateUrl: './new-roster.component.html',
  styleUrls: ['./new-roster.component.scss']
})
export class NewRosterComponent implements OnInit {

  private registerFailed: boolean;
  public registrationDone: boolean;
  private loading: boolean;
  private registerForm: FormGroup;

  constructor(private fb: FormBuilder, private authServ: AuthService) { }

  ngOnInit() {
    this.registerForm = this.fb.group({
        fname: [ null, Validators.required ],
        lname: [ null, Validators.required ],
        username: [ null],
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
  // register() {
  //   const val = this.registerForm.value;
  //   this.loading = true;
  //   this.authServ.register(val).subscribe( () => {
  //     this.loading = false;
  //     this.registrationDone = true;
  //   }, () => {
  //     this.loading = false;
  //     this.registerFailed = true;
  //   });
  // }
}
