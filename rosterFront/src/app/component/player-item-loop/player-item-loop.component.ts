import {Component, Input, OnInit} from '@angular/core';
import {Player} from "../../class/player";
import {Coffer} from "../../class/coffer";

@Component({
  selector: 'app-player-item-loop',
  templateUrl: './player-item-loop.component.html',
  styleUrls: ['./player-item-loop.component.scss']
})
export class PlayerItemLoopComponent implements OnInit {
@Input() player : Player;
@Input() coffers : Coffer[];
public lootsPlayer : any;
  constructor() { }

  ngOnInit(): void {
    this.lootsPlayer = this.player.loots;
  }

}
