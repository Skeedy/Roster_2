import { Component, OnInit } from '@angular/core';
import {Player} from "../../class/player";

@Component({
  selector: 'app-player',
  templateUrl: './player.component.html',
  styleUrls: ['./player.component.scss']
})
export class PlayerComponent implements OnInit {

  players: Player[];
  constructor() { }

  ngOnInit(): void {
  }

}
