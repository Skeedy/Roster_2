import {Player} from "./player";

export class Roster {
  id: number;
  rostername: string;
  email: string;
  player : Player[];
  isVerified: boolean;
}
