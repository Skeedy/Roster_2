import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import { MustMatch} from "../../functions/must-match.validator";
import {RosterService} from "../../service/roster.service";
import {SoundService} from "../../service/sound.service";

@Component({
  selector: 'app-new-roster',
  templateUrl: './new-roster.component.html',
  styleUrls: ['./new-roster.component.scss']
})
export class NewRosterComponent implements OnInit {

  public registerFailed: boolean;
  public registrationDone: boolean;
  public loading: boolean;
  public registerForm: FormGroup;
  public html: string;
  public showWarning = false;
  constructor(private fb: FormBuilder,
              private authServ: AuthService,
              private  rosterServ : RosterService,
              public soundService: SoundService) { }

  ngOnInit() {
    // récupère les entrées du formulaire
    this.registerForm = this.fb.group({
        rostername: [ null, Validators.required ],
      // vérifie les caractères du champs input password
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
      // Valide si les 2 champs de mot de passe sont les mêmes
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
      // this.soundService.playError();
      this.loading = false;
      this.registerFailed = true;
    });
  }

}
