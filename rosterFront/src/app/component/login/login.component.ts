import {Component, ElementRef, Input, OnInit, ViewChild} from '@angular/core';
import {FormGroup, FormBuilder, Validators, FormControl} from '@angular/forms';
import {AuthService} from '../../service/auth.service';
import {Router} from '@angular/router';
import {RosterService} from "../../service/roster.service";
import {LoadingService} from "../../service/loading.service";
import {SoundService} from "../../service/sound.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  @ViewChild('name') myDiv: ElementRef;
  loginForm = new FormGroup({
    rostername : new FormControl(''),
    password : new FormControl('')
  });
  public connexionFailed: boolean;
  public loading: boolean;
  public html: string;

  constructor(
    public sound: SoundService,
    private fb: FormBuilder,
    public loadingServ: LoadingService,
    private rosterServ: RosterService,
    private router: Router) { }

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
    // récupère les inputs du formulaire
    const val = this.loginForm.value;
    if (val.rostername && val.password) {
      // appelle la fonction login dans le roster Service
      this.rosterServ.login(val.rostername, val.password).subscribe(
          () => {
            // si réponse 200
            this.rosterServ.getRoster().subscribe(
              // appelle la fonction getRoster pour récupérer les données
                (roster) => {
                    this.loadingServ.removeLoading();
                  // si la variable isVerified est false, l'utilisateur est automatiquement déconnecté
                  if (!this.rosterServ._rosterSub.value.isVerified){
                    this.rosterServ.logout();
                    this.html = 'Your account needs to be activated to proceed, please check your email !'
                  }
                  else {
                    // redirige vers la page si il y a au moins une donnée
                    if (this.rosterServ._rosterSub.value.isVerified && this.rosterServ._rosterSub.value.player.length >= 1) {
                      // this.sound.playEnter();
                      this.router.navigate(['/roster']);
                    } else {
                      this.sound.playEnter();
                      this.router.navigate(['/player']);
                    }
                  }
                    this.loading = false;
                },
                (err) => {
                  this.loadingServ.removeLoading();
                  // this.sound.playError();
                  this.connexionFailed = true;
                  this.loading = false;
                });
          },
        // si réponse erreur du serveur
          (data) => {
            this.loadingServ.removeLoading();
            // this.sound.playError();
            this.connexionFailed = true;
            this.loading = false;
            this.html = 'Roster name or Password invalid !'
          } );
    }
  }
}
