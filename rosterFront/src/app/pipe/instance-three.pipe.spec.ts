import { InstanceThreePipe } from './instance-three.pipe';

describe('InstanceThreePipe', () => {
  it('create an instance', () => {
    const pipe = new InstanceThreePipe();
    expect(pipe).toBeTruthy();
  });
});
