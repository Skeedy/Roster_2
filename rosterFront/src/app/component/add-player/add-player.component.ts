import {Component, ElementRef, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {HttpClient} from "@angular/common/http";
import {PlayerListService} from "../../service/player-list.service";
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-add-player',
  templateUrl: './add-player.component.html',
  styleUrls: ['./add-player.component.scss']
})
export class AddPlayerComponent implements OnInit {
  public search : any;
  public isSearching = false;
  private loading: boolean;
  public newPlayerFrom : FormGroup;
  public notFound = false;
  public newChar: any;
  constructor(private fb: FormBuilder, private host: ElementRef<HTMLElement>, public searchServ: PlayerListService) { }

  ngOnInit(): void {
    this.newPlayerFrom = this.fb.group({
      fname: [ null, Validators.required ],
      lname: [ null, Validators.required ],
      server: [ null, Validators.required ]});
  }
  // 'https://xivapi.com/character/search?name='+val.fname+'+'+val.lname+'&server='+ val.server
  get f() { return this.newPlayerFrom.controls; }
  submit(){
    const val = this.newPlayerFrom.value;
    this.loading = true;
    this.isSearching = true;
    // appelle la function de recherche
    this.searchServ.searchPlayer(val.fname,val.lname,val.server).subscribe(data => {
        this.search = data;
        // si trouve un personnage
      if(this.search.Results[0]) {
        this.newChar = this.search.Results[0];
        // mémorise l'identifiant récupéré
        this.searchServ.addPlayer(this.newChar.ID);
        this.searchServ.isSubmitted = true;
        this.notFound = false;
        this.loading = false;
        this.isSearching = false;
        // reset le formulaire
        this.newPlayerFrom.reset();
      }
      else{
        this.notFound = true;
        this.isSearching = false;
        this.loading = false;
      }
    });
  }
  remove(){
    this.searchServ.isSubmitted = false;
    this.searchServ.removePlayer(this.newChar.ID);
    this.newChar = ''
    this.onCloseClicked();
  }
  onCloseClicked() {
    this.newPlayerFrom.reset();
  }

}
