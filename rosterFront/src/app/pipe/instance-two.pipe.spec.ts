import { InstanceTwoPipe } from './instance-two.pipe';

describe('InstanceTwoPipe', () => {
  it('create an instance', () => {
    const pipe = new InstanceTwoPipe();
    expect(pipe).toBeTruthy();
  });
});
