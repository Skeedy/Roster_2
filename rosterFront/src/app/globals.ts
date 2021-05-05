export class Globals {
  public static get APP_NAME(): string { return 'FFXIV Roster'; }
  public static get APP_TAB_TITLE(): string { return this.APP_NAME; }
  public static get APP_TAB_SEPERATOR(): string { return ' - '; }
  //public static get APP_API(): string { return 'http://90.120.9.48:8081'; }
  public static get APP_API(): string { return 'http://api.roster.fr'; }
  public static get APP_USER_TOKEN(): string { return 'id-Token'; }
  public static get APP_USER(): string { return 'id-user'; }
  public static get APP_ROSTER(): string { return 'id-roster'; }
  public static get APP_KEY(): string {return 'f0165bf321ee4780b7e92f06b0af31402f866a92644e4c9cbb6c8bb42b0a1846'}
}
