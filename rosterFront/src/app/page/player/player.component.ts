import { Component, OnInit } from '@angular/core';
import {Player} from "../../class/player";

@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit {

  private maxPlayer = 8;
  players: Player[];
  constructor() { }

  ngOnInit(): void {
  }
  addCharForm(){

  }
}
